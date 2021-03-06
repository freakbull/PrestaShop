<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace LegacyTests\Integration\classes\module;

use Cache;
use LegacyTests\TestCase\IntegrationTestCase;

use Module;
use PrestaShop\PrestaShop\Core\Addon\Module\ModuleManagerBuilder;

class ModuleGetPossibleHooksListTest extends IntegrationTestCase
{
    /**
     * Test if a module return the good possible hooks list.
     * This test is done on the bankwire generic module.
     *
     * Note: improves module list fixtures in order to get an explicit list of hooks.
     */
    public function testGetRightListForModule()
    {
        ModuleManagerBuilder::getInstance()->build()->install('bankwire');
        $module = Module::getInstanceByName('bankwire');
        Cache::clean('hook_alias');
        $possible_hooks_list = $module->getPossibleHooksList();

        $this->assertCount(2, $possible_hooks_list);

        $this->assertEquals('displayPaymentReturn', $possible_hooks_list[0]['name']);
        $this->assertEquals('paymentOptions', $possible_hooks_list[1]['name']);
    }

    public static function tearDownAfterClass()
    {
        Module::getInstanceByName('bankwire')->uninstall();
    }
}
