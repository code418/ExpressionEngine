<?php

namespace EllisLab\ExpressionEngine\Model\Category;

use EllisLab\ExpressionEngine\Model\Content\ContentModel;

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2003 - 2014, EllisLab, Inc.
 * @license		http://ellislab.com/expressionengine/user-guide/license.html
 * @link		http://ellislab.com
 * @since		Version 3.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * ExpressionEngine Category Model
 *
 * @package		ExpressionEngine
 * @subpackage	Category
 * @category	Model
 * @author		EllisLab Dev Team
 * @link		http://ellislab.com
 */
class Category extends ContentModel {

	protected static $_primary_key = 'cat_id';
	protected static $_gateway_names = array('CategoryGateway', 'CategoryFieldDataGateway');

	protected static $_relationships = array(
		'CategoryGroup' => array(
			'type' => 'belongsTo'
		),
		'ChannelEntries' => array(
			'type' => 'hasAndBelongsToMany',
			'model' => 'ChannelEntry',
			'pivot' => array(
				'table' => 'category_posts',
				'left' => 'cat_id',
				'right' => 'entry_id'
			)
		),
		'Parent' => array(
			'type' => 'belongsTo',
			'model' => 'Category',
			'from_key' => 'parent_id'
		),
		'Children' => array(
			'type' => 'hasMany',
			'model' => 'Category',
			'to_key' => 'parent_id'
		)
	);

	protected static $_validation_rules = array(
		'cat_name'			=> 'required|noHtml|xss',
		'cat_url_title'		=> 'required|alphaDash',
		'cat_description'	=> 'xss',
		'cat_order'			=> 'isNaturalNoZero'
	);

	// Properties
	protected $cat_id;
	protected $site_id;
	protected $group_id;
	protected $parent_id;
	protected $cat_name;
	protected $cat_url_title;
	protected $cat_description;
	protected $cat_image;
	protected $cat_order;

	/**
	 * A link back to the owning channel object.
	 *
	 * @return	Structure	A link to the Structure objects that defines this
	 * 						Content's structure.
	 */
	public function getStructure()
	{
		return $this->getCategoryGroup();
	}

}