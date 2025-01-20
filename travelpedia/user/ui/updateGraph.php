<?php
// Include the necessary JpGraph files
require_once ('../../jpgraph-4.4.2/src/jpgraph.php');
require_once ('../../jpgraph-4.4.2/src/jpgraph_bar.php');

// Get new data from the form
if (isset($_POST['data'])) {
    $data = array_map('intval', explode(',', $_POST['data']));
} else {
    $data = array(12, 5, 8, 15, 7, 9, 3, 13, 6, 17, 11, 4, 10);
}

// Create the graph
$graph = new Graph(800, 600);
$graph->SetScale('textlin');

// Setup the graph
$graph->title->Set('Bar Graph Example');
$graph->xaxis->title->Set('Value');
$graph->yaxis->title->Set('Frequency');
$graph->xaxis->SetTickLabels(array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Total'));

// Customize the graph appearance
$graph->SetMarginColor('white');
$graph->SetFrame(false);
$graph->xaxis->SetTitleMargin(30);
$graph->yaxis->SetTitleMargin(40);
$graph->xaxis->SetLabelAngle(45);

// Create the bar plot
$barplot = new BarPlot($data);
$barplot->SetFillColor('lightblue');
$barplot->SetColor('blue');
$barplot->SetWidth(0.5);

// Add the plot to the graph
$graph->Add($barplot);

// Stroke the graph to a file
$graph->Stroke('graph.png');

// Redirect back to the main page to display the updated graph
header('Location: home.php');
exit();
?>
