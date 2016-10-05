<?php
/*
 Copyright Game Server Services, Inc.

 Licensed under the Apache License, Version 2.0 (the "License");
 you may not use this file except in compliance with the License.
 You may obtain a copy of the License at

 http://www.apache.org/licenses/LICENSE-2.0

 Unless required by applicable law or agreed to in writing, software
 distributed under the License is distributed on an "AS IS" BASIS,
 WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 See the License for the specific language governing permissions and
 limitations under the License.
 */

namespace GS2\Auth;

use GS2\Core\Gs2Credentials as Gs2Credentials;
use GS2\Core\AbstractGs2Client as AbstractGs2Client;
use GS2\Core\Exception\NullPointerException as NullPointerException;

/**
 * GS2-Inbox クライアント
 *
 * @author Game Server Services, inc. <contact@gs2.io>
 * @copyright Game Server Services, Inc.
 *
 */
class Gs2AuthClient extends AbstractGs2Client {

	public static $ENDPOINT = 'auth';
	
	/**
	 * コンストラクタ
	 * 
	 * @param string $region リージョン名
	 * @param Gs2Credentials $credentials 認証情報
	 * @param array $options オプション
	 */
	public function __construct($region, Gs2Credentials $credentials, $options = []) {
		parent::__construct($region, $credentials, $options);
	}
	
	/**
	 * ログイン。<br>
	 * <br>
	 * GS2のサービスを利用するにあたってユーザの認証に必要となるアクセストークンを発行します。<br>
	 * アクセストークンの発行には以下の情報が必要となります。<br>
	 * <ul>
	 * <li>ユーザID</li>
	 * <li>サービスID</li>
	 * </ul>
	 * ユーザID には ログインするユーザのIDを指定してください。<br>
	 * GS2 はアカウント管理機能を持ちませんので、ユーザID は別途アカウント管理システムで発行したIDを指定する必要があります。<br>
	 * アカウントIDの文字種などには制限はありません。<br>
	 * <br>
	 * サービスID には任意の文字列を指定できます。<br>
	 * ここで指定したサービスIDにもとづいて、その後アクセストークンで利用できるGSIを制限するのに利用します。<br>
	 * <br>
	 * サービスの制限は GSI(AWSのIAMのようなもの) のセキュリティポリシーで設定することができます。<br>
	 * 例えば、GSIに設定されたセキュリティポリシーが service-0001 によるアクセスを許可する。という設定の場合、<br>
	 * service-0002 というサービスIDで発行されたアクセストークンとGSIの組み合わせでリクエストを出してもリジェクトされるようになります。<br>
	 * <br>
	 * これによって、下記のようなアクセスコントロールを同一アカウント内で実現できます。<br>
	 * <ul>
	 * <li>GSI(A) 許可するアクション(GS2Inbox:*) 許可するサービス(service-0001)</li>
	 * <li>GSI(B) 許可するアクション(GS2Stamina:*) 許可するサービス(service-0002)</li>
	 * </ul>
	 * この場合、service-0001 向けに発行されたアクセストークンと GSI(B) の組み合わせではサービスを利用することはできません。<br>
	 * そのため、service-0001 向けのアクセストークンでは GS2-Stamina を利用することはできないことになります。<br>
	 *
	 * @param array $request
	 * * serviceId => サービスID
	 * * userId => ユーザID
	 */
	public function login($request) {
		if(is_null($request)) throw new NullPointerException();
		$body = [];
		if(array_key_exists('serviceId', $request)) $body['serviceId'] = $request['serviceId'];
		if(array_key_exists('userId', $request)) $body['userId'] = $request['userId'];
		$query = [];
		return $this->doPost(
				'Gs2Auth',
				'Login',
				Gs2AuthClient::$ENDPOINT,
				'/login',
				$body,
				$query);
	}
}