<?php
/**
 * @version		$Id$
 * @package		Kunena
 * @subpackage	com_kunena
 * @copyright	(C) 2008 Kunena. All rights reserved, see COPYRIGHT.php
 * @license		GNU General Public License, see LICENSE.php
 * @link		http://www.kunena.com
 */

defined('_JEXEC') or die('Invalid Request.');

jimport('joomla.application.component.view');

/**
 * The HTML Kunena Categories View
 *
 * @package		Kunena
 * @subpackage	com_kunena
 * @version		1.0
 */
class KunenaViewCategories extends JView
{
	/**
	 * Display the view
	 *
	 * @access	public
	 */
	function display($tpl = null)
	{
		$state		= $this->get('State');
		$items		= $this->get('Items');
		$pagination	= $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		// Build the published state filter options.
		$options	= array();
		$options[]	= JHTML::_('select.option', '*', 'Any');
		$options[]	= JHTML::_('select.option', '1', 'Published');
		$options[]	= JHTML::_('select.option', '0', 'Unpublished');
		$options[]	= JHTML::_('select.option', '-2', 'Trash');

		$this->assignRef('state',		$state);
		$this->assignRef('items',		$items);
		$this->assignRef('pagination',	$pagination);
		$this->assignRef('filter_state',$options);

		parent::display($tpl);
	}

	/**
	 * Build the default toolbar.
	 *
	 * @access	protected
	 * @return	void
	 * @since	1.0
	 */
	function buildDefaultToolBar()
	{
		JToolBarHelper::title('Kunena: '.JText::_('Categories'), 'logo');

		$state = $this->get('State');
		JToolBarHelper::custom('category.publish', 'publish.png', 'publish_f2.png', 'Publish', true);
		JToolBarHelper::custom('category.unpublish', 'unpublish.png', 'unpublish_f2.png', 'Unpublish', true);
		if ($state->get('filter.state') == -2) {
			JToolBarHelper::deleteList('', 'category.delete');
		}
		else {
			JToolBarHelper::trash('category.trash');
		}
		JToolBarHelper::custom('category.edit', 'edit.png', 'edit_f2.png', 'Edit', true);
		JToolBarHelper::custom('category.edit', 'new.png', 'new_f2.png', 'New', false);
	}
}
