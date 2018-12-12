<?php
/**
 *
 * @package       phpBB Extension - TencentCOS
 * @copyright (c) 2017 Austin Maddox
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace AustinMaddox\tencentcos\migrations;

class release_0_1_0 extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return [
			['config.add', ['tencentcos_aws_access_key_id', '']],
			['config.add', ['tencentcos_aws_secret_access_key', '']],
			['config.add', ['tencentcos_region', '']],
			['config.add', ['tencentcos_bucket', '']],

			[
				'module.add',
				[
					'acp',
					'ACP_CAT_DOT_MODS',
					'ACP_TencentCOS_TITLE',
				],
			],
			[
				'module.add',
				[
					'acp',
					'ACP_TencentCOS_TITLE',
					[
						'module_basename' => '\AustinMaddox\tencentcos\acp\main_module',
						'modes'           => ['settings'],
					],
				],
			],
		];
	}
}
