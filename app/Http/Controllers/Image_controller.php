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

        # instantiates a client
        $imageAnnotator = new ImageAnnotatorClient();

        # the name of the image file to annotate
        $fileName = 'https://maipuhoy.com/wp-content/uploads/2019/01/FB_IMG_1547066578130-678x381.jpg';

        # prepare the image to be annotated
        $image = file_get_contents($fileName);

        # performs label detection on the image file
        $response = $imageAnnotator->labelDetection($image);
        $labels = $response->getLabelAnnotations();

        $result = '';
        if ($labels) {
            echo ("Labels:" . PHP_EOL);
            foreach ($labels as $label) {
                $result += ($label->getDescription() . PHP_EOL);
            }
        } else {
            $result = ('No label found' . PHP_EOL);
        }

        return response()->json($result);
    }
}
