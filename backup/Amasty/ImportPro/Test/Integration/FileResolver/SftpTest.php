<?php

declare(strict_types=1);

namespace Amasty\ImportPro\Test\Integration\FileResolver;

use Amasty\ImportCore\Api\ImportProcessInterface;
use Amasty\ImportCore\Import\Config\ProfileConfig;
use Amasty\ImportPro\Import\FileResolver\Type\SftpFile\ConfigInterface as ResolverConfigInterface;
use Amasty\ImportPro\Import\FileResolver\Type\SftpFile\FileResolver;
use Amasty\ImportPro\Test\Integration\FileResolver\Sftp\FakeSftp;
use Magento\Framework\ObjectManagerInterface;
use Magento\TestFramework\Helper\Bootstrap;

class SftpTest extends \PHPUnit\Framework\TestCase
{
    public const HOST = 'example.net';
    public const LOGIN = 'test_username';
    public const PASSWORD = 'test_password';
    public const FILE_CONTENTS = 'hello';
    public const PATH_TO_FILE = '/path/to/file.csv';

    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    protected function setUp(): void
    {
        $this->objectManager = Bootstrap::getObjectManager();
    }

    public function testExecute()
    {
        /** @var FakeSftp $fakeSftp */
        $fakeSftp = $this->objectManager->create(FakeSftp::class, [
            'host'     => self::HOST,
            'username' => self::LOGIN,
            'password' => self::PASSWORD,
            'files'    => [
                self::PATH_TO_FILE => self::FILE_CONTENTS
            ]
        ]);

        /** @var FileResolver $resolver */
        $resolver = $this->objectManager->create(
            FileResolver::class,
            ['sftp' => $fakeSftp]
        );

        /** @var ProfileConfig $profileConfig */
        $profileConfig = $this->objectManager->create(ProfileConfig::class);
        /** @var ResolverConfigInterface $resolverConfig */
        $resolverConfig = $this->objectManager->create(ResolverConfigInterface::class);
        $resolverConfig->setPath(self::PATH_TO_FILE);
        $resolverConfig->setUser(self::LOGIN);
        $resolverConfig->setHost(self::HOST);
        $resolverConfig->setPassword(self::PASSWORD);
        $profileConfig->getExtensionAttributes()->setSftpFileResolver($resolverConfig);
        $profileConfig->setSourceType('csv');

        /** @var ImportProcessInterface $importProcess */
        $importProcess = $this->objectManager->create(
            ImportProcessInterface::class,
            [
                'identity'      => 'some_identity',
                'profileConfig' => $profileConfig
            ]
        );

        $filePath = $resolver->execute($importProcess);

        $this->assertFileExists($filePath);
        $this->assertEquals(self::FILE_CONTENTS, file_get_contents($filePath));
        $this->assertFalse($fakeSftp->isOpened());
    }
}
