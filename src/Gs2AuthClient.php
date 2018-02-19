<?php
/*
 * Copyright 2016-2018 Game Server Services, Inc. or its affiliates. All Rights
 * Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace Gs2\Auth;

use Gs2\Core\AbstractGs2Client;
use Gs2\Core\Model\IGs2Credential;

use Gs2\Auth\Model\CreateOnceOnetimeTokenRequest;
use Gs2\Auth\Model\CreateOnceOnetimeTokenResult;
use Gs2\Auth\Model\CreateTimeOnetimeTokenRequest;
use Gs2\Auth\Model\CreateTimeOnetimeTokenResult;
use Gs2\Auth\Model\LoginRequest;
use Gs2\Auth\Model\LoginResult;
use Gs2\Auth\Model\LoginWithSignRequest;
use Gs2\Auth\Model\LoginWithSignResult;

/**
 * GS2 Auth API クライアント
 *
 * @author Game Server Services, Inc.
 *
 */
class Gs2AuthClient extends AbstractGs2Client {

	public static $ENDPOINT = "auth";

	/**
	 * コンストラクタ。
	 *
	 * @param IGs2Credential $credential 認証情報
	 */
	public function __construct(IGs2Credential $credential)
	{
		parent::__construct($credential);
	}


	/**
	 * 実行回数制限付きワンタイムトークンを発行します<br>
	 * <br>
	 *
	 * @param CreateOnceOnetimeTokenRequest $request リクエストパラメータ
	 * @return CreateOnceOnetimeTokenResult 結果
	 */

	public function createOnceOnetimeToken(CreateOnceOnetimeTokenRequest $request): CreateOnceOnetimeTokenResult {

		$body = [];
		
        $body['scriptName'] = $request->getScriptName();

        if($request->getGrant() !== null) $body['grant'] = $request->getGrant();
        if($request->getArgs() !== null) $body['args'] = $request->getArgs();
        $alternativeParams = [
            'headers' => [],
        ];
        if($request->getRequestId() !== null) {
            $alternativeParams['headers']['X-GS2-REQUEST-ID'] = $request->getRequestId();
        }

        return new CreateOnceOnetimeTokenResult(
                $this->doPost(
                        Gs2Auth::MODULE,
                        CreateOnceOnetimeTokenRequest::FUNCTION,
                        self::$ENDPOINT,
				        self::ENDPOINT_HOST. "/onetime/once/token",
				        json_encode($body),
                        $alternativeParams
                )
        );
	}


	/**
	 * 1回のみ実行を許可するワンタイムトークンを発行します<br>
	 * このトークンはスタミナの回復処理など、有効期間内だからといって何度も実行されたくない処理を1度だけ許可したい場合に発行します。<br>
	 * <br>
	 *
	 * @param CreateTimeOnetimeTokenRequest $request リクエストパラメータ
	 * @return CreateTimeOnetimeTokenResult 結果
	 */

	public function createTimeOnetimeToken(CreateTimeOnetimeTokenRequest $request): CreateTimeOnetimeTokenResult {

		$body = [];
		
        $body['scriptName'] = $request->getScriptName();

        $alternativeParams = [
            'headers' => [],
        ];
        if($request->getRequestId() !== null) {
            $alternativeParams['headers']['X-GS2-REQUEST-ID'] = $request->getRequestId();
        }

        return new CreateTimeOnetimeTokenResult(
                $this->doPost(
                        Gs2Auth::MODULE,
                        CreateTimeOnetimeTokenRequest::FUNCTION,
                        self::$ENDPOINT,
				        self::ENDPOINT_HOST. "/onetime/time/token",
				        json_encode($body),
                        $alternativeParams
                )
        );
	}


	/**
	 * ログイン処理を実行します<br>
	 * <br>
	 *
	 * @param LoginRequest $request リクエストパラメータ
	 * @return LoginResult 結果
	 */

	public function login(LoginRequest $request): LoginResult {

		$body = [];
		
        $body['serviceId'] = $request->getServiceId();
        $body['userId'] = $request->getUserId();

        $alternativeParams = [
            'headers' => [],
        ];
        if($request->getRequestId() !== null) {
            $alternativeParams['headers']['X-GS2-REQUEST-ID'] = $request->getRequestId();
        }

        return new LoginResult(
                $this->doPost(
                        Gs2Auth::MODULE,
                        LoginRequest::FUNCTION,
                        self::$ENDPOINT,
				        self::ENDPOINT_HOST. "/login",
				        json_encode($body),
                        $alternativeParams
                )
        );
	}


	/**
	 * GS2-Accountの認証署名付きログイン処理を実行します<br>
	 * <br>
	 *
	 * @param LoginWithSignRequest $request リクエストパラメータ
	 * @return LoginWithSignResult 結果
	 */

	public function loginWithSign(LoginWithSignRequest $request): LoginWithSignResult {

		$body = [];
		
        $body['serviceId'] = $request->getServiceId();
        $body['userId'] = $request->getUserId();
        $body['keyName'] = $request->getKeyName();
        $body['sign'] = $request->getSign();

        $alternativeParams = [
            'headers' => [],
        ];
        if($request->getRequestId() !== null) {
            $alternativeParams['headers']['X-GS2-REQUEST-ID'] = $request->getRequestId();
        }

        return new LoginWithSignResult(
                $this->doPost(
                        Gs2Auth::MODULE,
                        LoginWithSignRequest::FUNCTION,
                        self::$ENDPOINT,
				        self::ENDPOINT_HOST. "/login/signed",
				        json_encode($body),
                        $alternativeParams
                )
        );
	}


}