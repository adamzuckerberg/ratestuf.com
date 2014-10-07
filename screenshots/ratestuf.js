var args = require('system').args;

var page = require('webpage').create();

var address = args[1];

var output = args[2];

// page.viewportSize = {width:1920, height:900};
page.clipRect = {
	top: 178,
	left: 0,
	right: 586,
	height: 361,
	width: 586
};

page.open(address, function() {
 page.render(output);
 phantom.exit();
});
