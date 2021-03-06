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

namespace Gs2\Auth\Model;

use Gs2\Core\Control\Gs2BasicRequest;

/**
 * @author Game Server Services, Inc.
 */
class LoginRequest extends Gs2BasicRequest {

    const FUNCTION = "Login";

	/** @var string ログインするサービスID */
	private $serviceId;

	/** @var string ログインするユーザのID */
	private $userId;


	/**
	 * ログインするサービスIDを取得
	 *
	 * @return string ログインするサービスID
	 */
	public function getServiceId(): string {
		return $this->serviceId;
	}

	/**
	 * ログインするサービスIDを設定
	 *
	 * @param string $serviceId ログインするサービスID
	 */
	public function setServiceId(string $serviceId) {
		$this->serviceId = $serviceId;
	}

	/**
	 * ログインするサービスIDを設定
	 *
	 * @param string $serviceId ログインするサービスID
	 * @return LoginRequest
	 */
	public function withServiceId(string $serviceId): LoginRequest {
		$this->setServiceId($serviceId);
		return $this;
	}

	/**
	 * ログインするユーザのIDを取得
	 *
	 * @return string ログインするユーザのID
	 */
	public function getUserId(): string {
		return $this->userId;
	}

	/**
	 * ログインするユーザのIDを設定
	 *
	 * @param string $userId ログインするユーザのID
	 */
	public function setUserId(string $userId) {
		$this->userId = $userId;
	}

	/**
	 * ログインするユーザのIDを設定
	 *
	 * @param string $userId ログインするユーザのID
	 * @return LoginRequest
	 */
	public function withUserId(string $userId): LoginRequest {
		$this->setUserId($userId);
		return $this;
	}

}