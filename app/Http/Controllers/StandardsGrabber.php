<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * So, the API I use to get educational standards (https://commonstandardsproject.com/developers) really sucks.
 * If you attempt to access it via javascript from inside a given component, you will get a 401.
 * In theory, you should be able to register allowed origins for your API key, but, in practice, you can't.
 * However, you can just curl the pages and get them (making me wonder why the API key is necessary in the first place).
 * This controller exists purely so I can let the site backend call "curl" and pass results to the front end.
 * tl;dr the API makers are fucking morons, don't blame me that this is convoluted.
 **/

//Standard returned by API.
class standard {
    public $id = '';
    public $depth = 0;
    public $ancestorIds = [];
    public $children = [];
}

//Function to take standards structure returned by API and make it into an actual tree.
//API return value uses "ancestorIds" rather than an actual tree, so we're just gonna go over it recursively.
function makeStandardStruct($standardInp, &$standardOutp, $depth, $maximumDepth) {
    global $input;
    $input = 0;
    $standardObjs = array(); //to be discarded once emerging from this level of recursion;

    //Make standards into instances of class.
    foreach($standardInp['data']['standards'] as $standard) {
        if($standard['depth'] == $depth) {
            $standardObj = new standard();

            $standardObj->id = $standard['id'];
            $standardObj->depth = $standard['depth'];
            $standardObj->ancestorIds = $standard['ancestorIds'];
            $standardObj->children = array();

            $standardObjs[$standard['id']] = $standardObj;
        }
    }

    //Recursive call.
    if($depth != $maximumDepth) {
        makeStandardStruct($standardInp, $standardObjs, $depth + 1, $maximumDepth);
    }

    //At this point, we iterate through an array of standards who hierarchy is not yet obvious.
    foreach($standardObjs as $standard) {
        if(! empty($standard->ancestorIds)) {
            //"parentIds" are those 1 level above current node; JSON structure lists any ancestors as ancestor Ids.
            $parentIds = array();
            $largestDepth = -1;

            //Figure out the which ancestor has the largest depth.
            foreach($standard->ancestorIds as $ancId) {
                //"or equal to" relevant because ancestor Ids could theoretically intend for standard to exist as multiple
                // nodes under multiple parents, who are fraternal to one another.
                if($standardInp['data']['standards'][$ancId]['depth'] >= $largestDepth) {
                    $largestDepth = $standardInp['data']['standards'][$ancId]['depth'];
                }
            }

            foreach($standard->ancestorIds as $ancId) {
                if($standardInp['data']['standards'][$ancId]['depth'] >= $largestDepth) {
                    array_push($parentIds, $ancId);
                }
            }

            foreach($parentIds as $parentId) {
                $standardOutp[$parentId]->children[$standard->id] = $standard;
            }
        } elseif($depth == 0) {
            return $standardObjs;
        }
    }
}

//Since printing the standards tree requires recursion in a way Vue can't deal with, I generate the HTML in the back end.
//Specifically, this function generates the inside of a select multiple element.
function recursivePrint($standardsStruct, $standardJsonReturn, $depth, $maximumDepth) {
    $returnVal = '';
    $standards = $standardJsonReturn['data']['standards'];

    foreach($standardsStruct as $standardArrVal) {
        //If we're at the lowest level, we use "option". Otherwise, we use an "optgroup" title.
        if($standardArrVal->depth == $maximumDepth) {
            //By constantly increasing the margin, we ensure that hierarchy is visually represented.
            $margin = ((string) 10 * $depth) . 'px';
            $description = htmlspecialchars($standards[$standardArrVal->id]['description']);

            //Statement notation is optional piece of text that goes with standard.
            if(empty($standards[$standardArrVal->id]['statementNotation'])) {

                $returnVal .= '<option value = "'.$description.'" style = "margin-left: '.$margin.'" depth = '.$depth.'>';
                $returnVal .= $description;
                $returnVal .= '</option>';
            } else {
                $statementNotation = htmlspecialchars($standards[$standardArrVal->id]['statementNotation']);
                $standardHtml = $statementNotation.': '.$description;

                //It takes a lot of server resources to run constant API reqs, so it is easier to store standard
                //in db as text than as an API id or anything. Hence, we make it a value.
                $returnVal .= '<option value = "'.$standardHtml.'" style = "margin-left: '.$margin.'" depth = '.$depth.'>';
                $returnVal .= $standardHtml;
                $returnVal .= '</option>';
            }
        }

        //And now we do optgroups.
        else {
            $margin = ((string) 10 * $depth) . 'px';
            $description = htmlspecialchars($standards[$standardArrVal->id]['description']);

            if(empty($standards[$standardArrVal->id]['statementNotation'])){
                $returnVal .= '<optgroup style = "margin-left: '.$margin.'" label = "'.$description.'">';
            } else {
                $statementNotation = htmlspecialchars($standards[$standardArrVal->id]['statementNotation']);
                $label = $statementNotation.': '.$description;

                $returnVal .= '<optgroup style = "margin-left: '.$margin.'" label = "'.$label.'">';
            }

            //So, this is the magic of the function. We print the next level down inside the optgroups.
            $returnVal .= recursivePrint($standardArrVal->children, $standardJsonReturn, $depth + 1, $maximumDepth);
            $returnVal .= '</optgroup>';
        }
    }
    return $returnVal;
}

//Controller.
class StandardsGrabber extends Controller
{
    //List jurisdictions given by API.
    public function listJurisdictions() {
        $resp = '';
        $url = '"https://api.commonstandardsproject.com/api/v1/jurisdictions"';
        exec('curl '.$url.'', $resp);
        return $resp[0];
    }

    //List standard sets in jurisdiction, structure them in a tree fashion, and return select multiple html.
    public function listStandardSets($jurisdictionId) {
        $resp = '';
        $url = '"https://api.commonstandardsproject.com/api/v1/jurisdictions/"';
        exec('curl '.$url.$jurisdictionId, $resp);
        return $resp[0];
    }

    //For this one, we're gonna clean up the data given by the server to put it in a clean tree structure.
    //Then we return it as html.
    //I'm aware that returning html is lazy and bad, but Vue really isn't capable of the sort of recursive
    //stuff I want to do with this object.
    public function listStandards($standardSetId) {
        $resp = '';
        $url = '"https://api.commonstandardsproject.com/api/v1/standard_sets/"';
        exec('curl '.$url.$standardSetId, $resp);

        $standards = json_decode($resp[0], 1);
        $maxDepth = 0;

        foreach($standards['data']['standards'] as $standard) {
            if($standard['depth'] > $maxDepth) {
                $maxDepth = $standard['depth'];
            }
        }

        // this is my half-assed way of getting the compiler not to get pissed because I need to pass the second param by reference;
        $a = array();
        $standardStruct = makeStandardStruct($standards, $a, 0, $maxDepth);


        $returnHtml = recursivePrint($standardStruct, $standards, 0, $maxDepth);

        //This is literally just returning HTML.
        return $returnHtml;
    }
}
