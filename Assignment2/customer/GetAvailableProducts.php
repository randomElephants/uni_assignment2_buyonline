<?php
	//Load the goods document into a DOMDocument
	$goodsDoc = new DOMDocument("1.0");
	$goodsDoc->formatOutput = true;
    //TODO: remove one file level when testing finished
	$goodsDoc->load('../../../data/goods.xml');
	
	//load the XSL stylesheet into a DOMDocument
	$stylesheet = new DOMDocument("1.0");
	$stylesheet->load('goodsAvailable.xsl');
	
	//Create a new XSLT processor object
	$proc = new XSLTProcessor;
	
	//Load the XSL stylesheet to configure the processor
	$proc->importStyleSheet($stylesheet);
	
	//Transform the XML document using the processor
	$formattedHTML = $proc->transformToXML($goodsDoc);
	
	//send the output back to the client
	if ($formattedHTML != false) {
		echo($formattedHTML);
	} else {
		echo "<tr><td>There was an error formatting the document.<td></tr>";
	}
?>