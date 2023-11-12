<?php

declare(strict_types=1);

// SPDX-FileCopyrightText: Daniel Kesselberg <mail@danielkesselberg.de>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\Files_EMFViewer\AppInfo;

use OCA\Files_EMFViewer\Preview\EMF;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;

class Application extends App implements IBootstrap {
	public const APP_ID = 'files_emfviewer';

	public function __construct() {
		parent::__construct(self::APP_ID);
	}

	public function register(IRegistrationContext $context): void {
		$context->registerPreviewProvider(EMF::class, '/image\/emf/');
	}

	public function boot(IBootContext $context): void {
		// Hello!
	}
}
