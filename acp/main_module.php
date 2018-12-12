<?php
/**
 *
 * @package       phpBB Extension - TencentCOS
 * @copyright (c) 2017 Austin Maddox
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace AustinMaddox\tencentcos\acp;

class main_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $config, $request, $template, $user;

		$user->add_lang('acp/common');
		$this->tpl_name = 'tencentcos_body';
		$this->page_title = $user->lang('ACP_TencentCOS_TITLE');
		add_form_key('AustinMaddox/tencentcos');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('AustinMaddox/tencentcos'))
			{
				trigger_error('FORM_INVALID');
			}

			$errors = [];
			if (!preg_match('/[A-Za-z0-9]{36}/', $request->variable('tencentcos_aws_access_key_id', '')))
			{
				$errors[] = $user->lang('ACP_TencentCOS_ACCESS_KEY_ID_INVALID', $request->variable('tencentcos_aws_access_key_id', ''));
			}

			if (!preg_match('/[A-Za-z0-9]{32}/', $request->variable('tencentcos_aws_secret_access_key', '')))
			{
				$errors[] = $user->lang('ACP_TencentCOS_SECRET_ACCESS_KEY_INVALID', $request->variable('tencentcos_aws_secret_access_key', ''));
			}

			if (empty($request->variable('tencentcos_region', '')))
			{
				$errors[] = $user->lang('ACP_TencentCOS_REGION_INVALID');
			}

			if (empty($request->variable('tencentcos_bucket', '')))
			{
				$errors[] = $user->lang('ACP_TencentCOS_BUCKET_INVALID');
			}

			// If we have no errors so far, let's ensure our Tencent credentials are actually working.
			if (!count($errors))
			{
				try
				{
					// Instantiate an TencentCOS client.
					$tencentcos_client = new \Qcloud\Cos\Client([
						'credentials' => [
							'secretId'    => $request->variable('tencentcos_aws_access_key_id', ''),
							'secretKey' => $request->variable('tencentcos_aws_secret_access_key', ''),
						],
						'region'      => $request->variable('tencentcos_region', ''),
					]);

					// Upload a test file to ensure credentials are valid and everything is working properly.
					$tencentcos_client->putObject(['Bucket' => $request->variable('tencentcos_bucket', ''), 'Key' => 'test/test.txt','Body' => 'Hello World!']);

					// Delete the test file.
					$tencentcos_client->deleteObject([
						'Bucket' => $request->variable('tencentcos_bucket', ''),
						'Key'    => 'test.txt',
					]);
				}
				catch (\Exception $e)
				{
					$errors[] = $e->getMessage();
				}
			}

			// If we still don't have any errors, it is time to set the database config values.
			if (!count($errors))
			{
				$config->set('tencentcos_aws_access_key_id', $request->variable('tencentcos_aws_access_key_id', ''));
				$config->set('tencentcos_aws_secret_access_key', $request->variable('tencentcos_aws_secret_access_key', ''));
				$config->set('tencentcos_region', $request->variable('tencentcos_region', ''));
				$config->set('tencentcos_bucket', $request->variable('tencentcos_bucket', ''));
				$config->set('tencentcos_is_enabled', 1);

				trigger_error($user->lang('ACP_TencentCOS_SETTING_SAVED') . adm_back_link($this->u_action));
			}
		}

		$template->assign_vars([
			'U_ACTION'                 => $this->u_action,
			'TencentCOS_ERROR'                 => isset($errors) ? ((count($errors)) ? implode('<br /><br />', $errors) : '') : '',
			'TencentCOS_ACCESS_KEY_ID'     => $config['tencentcos_aws_access_key_id'],
			'TencentCOS_SECRET_ACCESS_KEY' => $config['tencentcos_aws_secret_access_key'],
			'TencentCOS_REGION'                => $config['tencentcos_region'],
			'TencentCOS_BUCKET'                => $config['tencentcos_bucket'],
			'TencentCOS_IS_ENABLED'            => ($config['tencentcos_is_enabled']) ? 'Enabled' : 'Disabled',
		]);
	}
}
