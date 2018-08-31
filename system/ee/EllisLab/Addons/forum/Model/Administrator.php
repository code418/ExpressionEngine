<?php
/**
 * ExpressionEngine (https://expressionengine.com)
 *
 * @link      https://expressionengine.com/
 * @copyright Copyright (c) 2003-2018, EllisLab, Inc. (https://ellislab.com)
 * @license   https://expressionengine.com/license
 */

namespace EllisLab\Addons\Forum\Model;

use EllisLab\ExpressionEngine\Service\Model\Model;

/**
 * Administrator Model for the Forum
 *
 * A model representing an administrator in the Forum.
 */
class Administrator extends Model {

	protected static $_primary_key = 'admin_id';
	protected static $_table_name = 'forum_administrators';

	protected static $_typed_columns = array(
		'board_id'        => 'int',
		'admin_group_id'  => 'int',
		'admin_member_id' => 'int',
	);

	protected static $_relationships = array(
		'Board' => array(
			'type' => 'belongsTo'
		),
		'Member' => array(
			'type'     => 'belongsTo',
			'model'    => 'ee:Member',
			'from_key' => 'admin_member_id',
			'to_key'   => 'member_id',
			'inverse' => array(
				'name' => 'Administrator',
				'type' => 'hasMany'
			)
		),
		'Role' => array(
			'type'     => 'belongsTo',
			'model'    => 'ee:Role',
			'from_key' => 'admin_group_id',
			'to_key'   => 'role_id',
			'inverse' => array(
				'name' => 'Administrator',
				'type' => 'hasMany'
			)
		),
	);

	protected static $_validation_rules = array(
		'board_id'        => 'required',
		'admin_group_id'  => 'required',
		'admin_member_id' => 'required',
	);

	protected $admin_id;
	protected $board_id;
	protected $admin_group_id;
	protected $admin_member_id;

	public function getAdminName()
	{
		$name = "";

		if ($this->admin_group_id)
		{
			$name = $this->Role->name;
		}
		elseif ($this->admin_member_id)
		{
			$name = $this->Member->getMemberName();
		}

		return $name;
	}

	public function getType()
	{
		$type = "";

		if ($this->admin_group_id)
		{
			$type = lang('group');
		}
		elseif ($this->admin_member_id)
		{
			$type = lang('individual');
		}

		return $type;
	}

}

// EOF
