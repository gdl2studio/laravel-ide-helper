<?php

namespace Gdl2Studio\IdeHelper\Tests\Unit;

use Gdl2Studio\IdeHelper\PhpFile;
use Gdl2Studio\IdeHelper\Tests\TestCase;

class PhpFileParserTest extends TestCase
{
    /**
     * @test
     */
    public function it_reads_php_file()
    {
        $pathname = app_path('/Support/DummyB.php');

        $expected = [
            'pathname'         => realpath($pathname),
            'relativePathname' => DIRECTORY_SEPARATOR.'Support'.DIRECTORY_SEPARATOR.'DummyB.php',
            'relativePath'     => DIRECTORY_SEPARATOR.'Support',
        ];

        $fileInfo = PhpFile::make($pathname, app_path())->getFileInfo();
        $this->assertEquals($expected['pathname'], $fileInfo->getPathname());
        $this->assertEquals($expected['relativePathname'], $fileInfo->getRelativePathname());
        $this->assertEquals($expected['relativePath'], $fileInfo->getRelativePath());
    }

    /**
     * @test
     */
    public function it_reads_namespace()
    {
        $this->assertEquals(
            'TestApp\Support',
            PhpFile::make(app_path('/Support/DummyB.php'))->getNamespace()
        );

        $this->assertEquals(
            'TestApp\Facades',
            PhpFile::make(app_path('/Facades/DummyBFacade.php'))->getNamespace()
        );
    }

    /**
     * @test
     */
    public function it_reads_defined_classname()
    {
        $this->assertEquals(
            'TestApp\Support\DummyB',
            PhpFile::make(app_path('/Support/DummyB.php'))->getFQCN()
        );

        $this->assertEquals(
            'TestApp\Facades\DummyBFacade',
            PhpFile::make(app_path('/Facades/DummyBFacade.php'))->getFQCN()
        );
    }

    /**
     * @test
     */
    public function it_reads_class_annotations()
    {
        $annotations = PhpFile::make(app_path('/Support/DummyB.php'))->getClassAnnotation();

        $this->assertStringContainsString(
            'This is a DummyB class annotation',
            $annotations
        );

        $this->assertStringNotContainsString(
            'some other comment',
            $annotations
        );
    }

    /**
     * @test
     */
    public function it_can_modify_and_clean_up_class_annotations()
    {
        $phpFile = PhpFile::make(app_path('/Facades/DummyBFacade.php'));

        $original = $phpFile->getContents();
        $modified = $phpFile->updateFacadeAnnotation(true);
        $cleaned = $phpFile->cleanUpClassAnnotation(true);
        // dump($original, $modified, $cleaned);
        $this->assertNotEquals($original, $modified);
        $this->assertEquals($original, $cleaned);

        $phpFile = PhpFile::make(app_path('/DummyAFacade.php'));

        $original = $phpFile->getContents();
        $modified = $phpFile->updateFacadeAnnotation(true);
        $cleaned = $phpFile->cleanUpClassAnnotation(true);
        //dump($original, $modified, $cleaned);
        $this->assertNotEquals($original, $modified);
        $this->assertEquals($original, $cleaned);
    }
}
