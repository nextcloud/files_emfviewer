<?php

declare(strict_types=1);

// SPDX-FileCopyrightText: Daniel Kesselberg <mail@danielkesselberg.de>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\Files_EMFViewer\Migration;

use OCA\Files_EMFViewer\AppInfo\Application;
use OCP\Migration\IOutput;

class UnregisterMimeType extends MimeTypeMigration {
	public function getName() {
		return 'Unregister MIME type for "image/emf"';
	}

	public function run(IOutput $output) {
		$output->info('Unregistering the mimetype...');

		// Register the mime type for existing files
		$this->unregisterForExistingFiles();

		// Register the mime type for new files
		$this->unregisterForNewFiles();

		$output->info('The mimetype was successfully unregistered.');
	}

	private function unregisterForExistingFiles() {
		$mimeTypeId = $this->mimeTypeLoader->getId('application/octet-stream');
		$this->mimeTypeLoader->updateFilecache('emf', $mimeTypeId);
	}

	private function unregisterForNewFiles() {
		$mappingFile = $this->getMappingFile();
		$added = $this->config->getAppValue(Application::APP_ID, self::ADDED_MIMETYPEMAPPING, 'no') === 'yes';

		if ($added && file_exists($mappingFile)) {
			try {
				$mapping = json_decode(file_get_contents($mappingFile), true, 512, JSON_THROW_ON_ERROR);
				unset($mapping['emf']);
			} catch (\JsonException) {
				$mapping = [];
			}
			file_put_contents($mappingFile, json_encode($mapping, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
			$this->config->deleteAppValue(Application::APP_ID, self::ADDED_MIMETYPEMAPPING);
		}
	}
}
