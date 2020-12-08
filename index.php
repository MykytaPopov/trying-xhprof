<?php

use App\FixturesGenerator;
use App\FunctionsHandler;
use App\FunctionsStrictHandler;
use App\LoopHandler;
use App\LoopStrictHandler;

require __DIR__ . '/vendor/autoload.php';

// generate data as if we get it with API
$generator = new FixturesGenerator();
$oldInputData = $generator->load(10000)->getJsonData();
$newInputData = $generator->removeValues(500)->resetValues(200)->addValues(250)->getJsonData();

// Start handle data obtained from API
// Our old data
$oldData = json_decode($oldInputData, true);
// New data from the API
$newData = json_decode($newInputData, true);

// Create handlers
$loopHandler = new LoopHandler();
$loopStrictHandler = new LoopStrictHandler();
$functionsHandler = new FunctionsHandler();
$functionsStrictHandler = new FunctionsStrictHandler();

// Check the execution time
xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
$loopDiff = $loopHandler->findDiff($oldData, $newData);
$loopStrictDiff = $loopStrictHandler->findDiff($oldData, $newData);
$functionsDiff = $functionsHandler->findDiff($oldData, $newData);
$functionsStrictHandler = $functionsStrictHandler->findDiff($oldData, $newData);
$xhprof_data = xhprof_disable();

// Prepare rendering the results of profiling
include_once "/app/xhprof/xhprof_lib/utils/xhprof_lib.php";
include_once "/app/xhprof/xhprof_lib/utils/xhprof_runs.php";
$xhprof_runs = new XHProfRuns_Default();
$run_id = $xhprof_runs->save_run($xhprof_data, "test");

echo "<a target=\"_blank\" href=\"xhprof/xhprof_html/index.php?run={$run_id}&source=test\">Посмотреть профайлинг $run_id</a>";
