<?php
/**
 * iroha Board Project
 *
 * @author        Kotaro Miura
 * @copyright     2015-2021 iroha Soft, Inc. (https://irohasoft.jp)
 * @link          https://irohaboard.irohasoft.jp
 * @license       https://www.gnu.org/licenses/gpl-3.0.en.html GPL License
 */

App::uses('AppController', 'Controller');

/**
 * Groups Controller
 * https://book.cakephp.org/2/ja/controllers.html
 */
class GroupsController extends AppController
{
	/**
	 * 使用するコンポーネント
	 * https://book.cakephp.org/2/ja/core-libraries/toc-components.html
	 */
	public $components = [
		'Paginator',
		'Security' => [
			'csrfUseOnce' => false,
		],
	];

	/**
	 * グループ一覧を表示
	 */
	public function admin_index()
	{
		$this->Group->recursive = 0;
		$this->Group->virtualFields['course_title'] = 'GroupCourse.course_title'; // 外部結合テーブルのフィールドによるソート用
		
		$this->Paginator->settings = [
			'fields' => ['*', 'GroupCourse.course_title'],
			'limit' => 20,
			'order' => 'created desc',
			'joins' => [
				['type' => 'LEFT OUTER', 'alias' => 'GroupCourse',
						'table' => '(SELECT gc.group_id, group_concat(c.title order by c.id SEPARATOR \', \') as course_title FROM ib_groups_courses gc INNER JOIN ib_courses c ON c.id = gc.course_id  GROUP BY gc.group_id)',
						'conditions' => 'Group.id = GroupCourse.group_id']
			]
		];
		
		$this->set('groups', $this->Paginator->paginate());
	}

	/**
	 * グループの追加
	 */
	public function admin_add()
	{
		$this->admin_edit();
		$this->render('admin_edit');
	}

	/**
	 * グループの編集
	 * @param int $group_id 編集するグループのID
	 */
	public function admin_edit($group_id = null)
	{
		if($this->isEditPage() && !$this->Group->exists($group_id))
		{
			throw new NotFoundException(__('Acceso inválido'));
		}
		
		if($this->request->is(['post', 'put']))
		{
			if($this->Group->save($this->request->data))
			{
				$this->Flash->success(__('El grupo ha sido guardado'));
				return $this->redirect(['action' => 'index']);
			}
			else
			{
				$this->Flash->error(__('No se pudo guardar el grupo. Por favor, intente nuevamente.'));
			}
		}
		else
		{
			$this->request->data = $this->Group->get($group_id);
		}
		
		$courses = $this->Group->Course->find('list');
		$this->set(compact('courses'));
	}

	/**
	 * グループの削除
	 * @param int $group_id 削除するグループのID
	 */
	public function admin_delete($group_id = null)
	{
		$this->Group->id = $group_id;
		
		if(!$this->Group->exists())
		{
			throw new NotFoundException(__('Grupo inválido'));
		}
		
		$this->request->allowMethod('post', 'delete');
		
		if($this->Group->delete())
		{
			$this->Flash->success(__('El grupo ha sido eliminado'));
		}
		else
		{
			$this->Flash->error(__('No se pudo eliminar el grupo. Por favor, intente nuevamente.'));
		}
		
		return $this->redirect(['action' => 'index']);
	}
}
