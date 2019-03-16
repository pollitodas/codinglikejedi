<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

# imports the Google Cloud client library
use Google\Cloud\Vision\V1\ImageAnnotatorClient;

class Image_controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    { }

    public function image(request $request)
    {
        putenv('GOOGLE_APPLICATION_CREDENTIALS=/Applications/MAMP/htdocs/codinglikejedi/codinglikejedi-c64ef958d532.json');
        $fileName = 'IMG_2219.JPG';
        $imageAnnotator = new ImageAnnotatorClient();
        $image = file_get_contents($fileName);
        $response = $imageAnnotator->documentTextDetection($image);
        $annotation = $response->getFullTextAnnotation();
        if ($annotation) {
            foreach ($annotation->getPages() as $page) {
                foreach ($page->getBlocks() as $block) {
                    $block_text = '';
                    foreach ($block->getParagraphs() as $paragraph) {
                        foreach ($paragraph->getWords() as $word) {
                            foreach ($word->getSymbols() as $symbol) {
                                $block_text .= $symbol->getText();
                            }
                            $block_text .= ' ';
                        }
                        $block_text .= "\n";
                    }
                    printf('Block content: %s', $block_text);
                    printf('Block confidence: %f' . PHP_EOL,
                    $block->getConfidence());
                    $vertices = $block->getBoundingBox()->getVertices();
                    $bounds = [];
                    foreach ($vertices as $vertex) {
                        $bounds[] = sprintf('(%d,%d)', $vertex->getX(),
                            $vertex->getY());
                    }
                    print('Bounds: ' . join(', ',$bounds) . PHP_EOL);
                    print(PHP_EOL);
                }
            }
        } else {
            print('No text found' . PHP_EOL);
        }
    
        $imageAnnotator->close();
    
    
    
    

        //return response()->json($objects);
    }
}
