function demoTwoPageDocument() {
	var doc = new jsPDF();
	var img = new Image();
	var d = new Date();
	var month = new Array();
	  month[0] = "January";
	  month[1] = "February";
	  month[2] = "March";
	  month[3] = "April";
	  month[4] = "May";
	  month[5] = "June";
	  month[6] = "July";
	  month[7] = "August";
	  month[8] = "September";
	  month[9] = "October";
	  month[10] = "November";
	  month[11] = "December";
	img.src = basicpdf.pluginsUrl+'/rate-calculator/public/pix/logo.png';
	img.onload = function(){
		doc.addImage(img , 'png',55, 20, 90, 25);
	doc.setFont('Arial', 'bold');
	doc.setFontSize(20);
	doc.text(60, 60, 'ESTIMATED FEE QUOTE');
	doc.setFontSize(10);
	doc.text(10, 70, 'Issued by:');
	doc.text(150, 70, 'Quote date:');
	doc.setFont('Arial', 'italic');	
	doc.text(10, 75, 'Atlas Title Company');
	doc.text(10, 80, '1 Corporate Park, Suite 200');
	doc.text(10, 85, 'Irvine, CA  92606');	
	doc.text(150, 75, month[d.getMonth()]+' '+d.getDate()+', '+d.getFullYear());
	doc.setFont('Arial', 'bold');
	doc.setFontSize(15);
	doc.text(10, 100, 'Summary');
	doc.line(10,104,190,104);
	doc.setFont('Arial', 'italic');
	doc.setFontSize(10);
	doc.text(10, 114, 'State:');
	doc.text(10, 120, 'County:');
	doc.text(10, 126, 'Transaction Type:');
	doc.text(130, 114, 'Loan Amount:');
	if(jQuery('.ttypeP').html() == 'Purchase'){
		doc.text(130, 120, 'Sales price:');
	}
	doc.text(40, 114, jQuery('.stateP').html());//state
	doc.text(40, 120, jQuery('.countyP').html());//county
	doc.text(40, 126, jQuery('.ttypeP').html());
	doc.text(160, 114, jQuery('.loanP').html());
	if(jQuery('.ttypeP').html() == 'Purchase'){
		doc.text(160, 120, jQuery('.salesP').html());
	}
	doc.setFont('Arial', 'bold');
	doc.setFontSize(15);
	doc.text(10, 145, 'Description');
	if(jQuery('.ttypeP').html() == 'Purchase'){
		doc.text(115, 145, 'Buyer');
		doc.text(170, 145, 'Seller');
	}else{
		doc.text(170, 145, 'Borrower');
	}
	doc.line(10,149,190,149);
	doc.setFont('Arial', 'normal');
	doc.setFontSize(10);
	if(jQuery('.servicesP').html() == 'Title' || jQuery('.servicesP').html() == 'Title and Escrow'){		
        if(jQuery('.ttypeP').html() == "Purchase"){
        	doc.text(10,155,'Lender\'s Title Insurance*');
			doc.text(115,155,jQuery('.lenderP').html());
            doc.text(10,161,'Owner\'s Title Insurance*');
            doc.text(170,161,jQuery('.ownerP').html());
        }else{
        	doc.text(10,155,'Lender\'s Title Insurance*');
			doc.text(170,155,jQuery('.lenderP').html());
        }
	}
	if(jQuery('.servicesP').html() == 'Escrow' || jQuery('.servicesP').html() == 'Title and Escrow'){
        doc.text(10,167,'Closing/Escrow Fee');
        doc.text(170,167,jQuery('.closeP').html());
        doc.text(10,173,'Notary Fee');
        doc.text(170,173,jQuery('.notaryP').html());
        doc.text(10,179,'Recording Fee**');
        doc.text(170,179,jQuery('.recordingP').html());
        if(jQuery('.ttypeP').html() == "Purchase"){
            doc.text(10,185,'Affordable Housing Fee');
            doc.text(170,185,jQuery('.housingP').html());
        }
    }
    doc.line(10,189,190,189);
    doc.setFont('Arial', 'bold');
	doc.setFontSize(10);
	doc.text(15,193,'Total');
	doc.text(170,193,jQuery('.totalP').html());
	if(jQuery('.servicesP').html() == 'Title' || jQuery('.servicesP').html() == 'Title and Escrow'){
        if(jQuery('.ttypeP').html() == "Purchase"){
        	doc.text(115,193,jQuery('.lenderP').html());
        }
    }
    doc.setFont('Arial', 'italic');
    doc.text(15,213,'*Any applicable endorsement charges are not included in this quote.');
    doc.text(15,219,'**Charges can vary based on # of pages and document types.');	
	// Save the PDF
	doc.save('quote-result.pdf');
	}
}

function demoLandscape() {
	var doc = new jsPDF('landscape');
	doc.text(20, 20, 'Hello landscape world!');

	// Save the PDF
	doc.save('Test.pdf');
}

function demoFontSizes() {
	var doc = new jsPDF();
	doc.setFontSize(22);
	doc.text(20, 20, 'This is a title');
	
	doc.setFontSize(16);
	doc.text(20, 30, 'This is some normal sized text underneath.');
	
	doc.save('Test.pdf');
}

function demoFontTypes() {
	var doc = new jsPDF();
	
	doc.text(20, 20, 'This is the default font.');
	
	doc.setFont("courier");
	doc.setFontType("normal");
	doc.text(20, 30, 'This is courier normal.');
	
	doc.setFont("times");
	doc.setFontType("italic");
	doc.text(20, 40, 'This is times italic.');
	
	doc.setFont("helvetica");
	doc.setFontType("bold");
	doc.text(20, 50, 'This is helvetica bold.');
	
	doc.setFont("courier");
	doc.setFontType("bolditalic");
	doc.text(20, 60, 'This is courier bolditalic.');
	
	doc.save('Test.pdf');
}

function demoTextColors() {
	var doc = new jsPDF();

	doc.setTextColor(100);
	doc.text(20, 20, 'This is gray.');
	
	doc.setTextColor(150);
	doc.text(20, 30, 'This is light gray.');
	
	doc.setTextColor(255,0,0);
	doc.text(20, 40, 'This is red.');
	
	doc.setTextColor(0,255,0);
	doc.text(20, 50, 'This is green.');
	
	doc.setTextColor(0,0,255);
	doc.text(20, 60, 'This is blue.');
	
	// Output as Data URI
	doc.output('datauri');
}

function demoMetadata() {
	var doc = new jsPDF();
	doc.text(20, 20, 'This PDF has a title, subject, author, keywords and a creator.');
	
	// Optional - set properties on the document
	doc.setProperties({
		title: 'Title',
		subject: 'This is the subject',
		author: 'James Hall',
		keywords: 'generated, javascript, web 2.0, ajax',
		creator: 'MEEE'
	});
	
	doc.save('Test.pdf');
}

function demoUserInput() {	
	var name = prompt('What is your name?');
	var multiplier = prompt('Enter a number:');
	multiplier = parseInt(multiplier);

	var doc = new jsPDF();
	doc.setFontSize(22);	
	doc.text(20, 20, 'Questions');
	doc.setFontSize(16);
	doc.text(20, 30, 'This belongs to: ' + name);
	
	for(var i = 1; i <= 12; i ++) {
		doc.text(20, 30 + (i * 10), i + ' x ' + multiplier + ' = ___');
	}
	
	doc.addPage();
	doc.setFontSize(22);
	doc.text(20, 20, 'Answers');
	doc.setFontSize(16);
	
	for (i = 1; i <= 12; i ++) {
		doc.text(20, 30 + (i * 10), i + ' x ' + multiplier + ' = ' + (i * multiplier));
	}
	doc.save('Test.pdf');
	
}

function demoRectangles() {
	var doc = new jsPDF();

	doc.rect(20, 20, 10, 10); // empty square

	doc.rect(40, 20, 10, 10, 'F'); // filled square
	
	doc.setDrawColor(255, 0, 0);
	doc.rect(60, 20, 10, 10); // empty red square
	
	doc.setDrawColor(255, 0, 0);
	doc.rect(80, 20, 10, 10, 'FD'); // filled square with red borders
	
	doc.setDrawColor(0);
	doc.setFillColor(255, 0, 0);
	doc.rect(100, 20, 10, 10, 'F'); // filled red square
	
	doc.setDrawColor(0);
	doc.setFillColor(255, 0, 0);
	doc.rect(120, 20, 10, 10, 'FD'); // filled red square with black borders

	doc.setDrawColor(0);
	doc.setFillColor(255, 255, 255);
	doc.roundedRect(140, 20, 10, 10, 3, 3, 'FD'); //  Black square with rounded corners

	doc.save('Test.pdf');
}

function demoLines() {
	var doc = new jsPDF();

	doc.line(20, 20, 60, 20); // horizontal line
		
	doc.setLineWidth(0.5);
	doc.line(20, 25, 60, 25);
	
	doc.setLineWidth(1);
	doc.line(20, 30, 60, 30);
	
	doc.setLineWidth(1.5);
	doc.line(20, 35, 60, 35);
	
	doc.setDrawColor(255,0,0); // draw red lines
	
	doc.setLineWidth(0.1);
	doc.line(100, 20, 100, 60); // vertical line
	
	doc.setLineWidth(0.5);
	doc.line(105, 20, 105, 60);
	
	doc.setLineWidth(1);
	doc.line(110, 20, 110, 60);
	
	doc.setLineWidth(1.5);
	doc.line(115, 20, 115, 60);
	
	// Output as Data URI
	doc.output('datauri');
}

function demoCircles() {
	var doc = new jsPDF();

	doc.ellipse(40, 20, 10, 5);

	doc.setFillColor(0,0,255);
	doc.ellipse(80, 20, 10, 5, 'F');
	
	doc.setLineWidth(1);
	doc.setDrawColor(0);
	doc.setFillColor(255,0,0);
	doc.circle(120, 20, 5, 'FD');

	doc.save('Test.pdf');
}

function demoTriangles() {
	var doc = new jsPDF();

	doc.triangle(60, 100, 60, 120, 80, 110, 'FD');
	
	doc.setLineWidth(1);
	doc.setDrawColor(255,0,0);
	doc.setFillColor(0,0,255);
	doc.triangle(100, 100, 110, 100, 120, 130, 'FD');
	
	doc.save('Test.pdf');
}

function demoImages() {
	// Because of security restrictions, getImageFromUrl will
	// not load images from other domains.  Chrome has added
	// security restrictions that prevent it from loading images
	// when running local files.  Run with: chromium --allow-file-access-from-files --allow-file-access
	// to temporarily get around this issue.
	var getImageFromUrl = function(url, callback) {
		var img = new Image(), data, ret = {
			data: null,
			pending: true
		};
		
		img.onError = function() {
			throw new Error('Cannot load image: "'+url+'"');
		};
		img.onload = function() {
			var canvas = document.createElement('canvas');
			document.body.appendChild(canvas);
			canvas.width = img.width;
			canvas.height = img.height;

			var ctx = canvas.getContext('2d');
			ctx.drawImage(img, 0, 0);
			// Grab the image as a jpeg encoded in base64, but only the data
			data = canvas.toDataURL('image/jpeg').slice('data:image/jpeg;base64,'.length);
			// Convert the data to binary form
			data = atob(data);
			document.body.removeChild(canvas);

			ret['data'] = data;
			ret['pending'] = false;
			if (typeof callback === 'function') {
				callback(data);
			}
		};
		img.src = url;

		return ret;
	};

	// Since images are loaded asyncronously, we must wait to create
	// the pdf until we actually have the image data.
	// If we already had the jpeg image binary data loaded into
	// a string, we create the pdf without delay.
	var createPDF = function(imgData) {
		var doc = new jsPDF();

		doc.addImage(imgData, 'JPEG', 10, 10, 50, 50);
		doc.addImage(imgData, 'JPEG', 70, 10, 100, 120);

		doc.save('output.pdf');

	}

	getImageFromUrl('thinking-monkey.jpg', createPDF);
}

function demoStringSplitting() {

	var pdf = new jsPDF('p','in','letter')
	, sizes = [12, 16, 20]
	, fonts = [['Times','Roman'],['Helvetica',''], ['Times','Italic']]
	, font, size, lines
	, margin = 0.5 // inches on a 8.5 x 11 inch sheet.
	, verticalOffset = margin
	, loremipsum = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus id eros turpis. Vivamus tempor urna vitae sapien mollis molestie. Vestibulum in lectus non enim bibendum laoreet at at libero. Etiam malesuada erat sed sem blandit in varius orci porttitor. Sed at sapien urna. Fusce augue ipsum, molestie et adipiscing at, varius quis enim. Morbi sed magna est, vel vestibulum urna. Sed tempor ipsum vel mi pretium at elementum urna tempor. Nulla faucibus consectetur felis, elementum venenatis mi mollis gravida. Aliquam mi ante, accumsan eu tempus vitae, viverra quis justo.\n\nProin feugiat augue in augue rhoncus eu cursus tellus laoreet. Pellentesque eu sapien at diam porttitor venenatis nec vitae velit. Donec ultrices volutpat lectus eget vehicula. Nam eu erat mi, in pulvinar eros. Mauris viverra porta orci, et vehicula lectus sagittis id. Nullam at magna vitae nunc fringilla posuere. Duis volutpat malesuada ornare. Nulla in eros metus. Vivamus a posuere libero.'

	// Margins:
	pdf.setDrawColor(0, 255, 0)
		.setLineWidth(1/72)
		.line(margin, margin, margin, 11 - margin)
		.line(8.5 - margin, margin, 8.5-margin, 11-margin)

	// the 3 blocks of text
	for (var i in fonts){
		if (fonts.hasOwnProperty(i)) {
			font = fonts[i]
			size = sizes[i]

			lines = pdf.setFont(font[0], font[1])
						.setFontSize(size)
						.splitTextToSize(loremipsum, 7.5)
			// Don't want to preset font, size to calculate the lines?
			// .splitTextToSize(text, maxsize, options)
			// allows you to pass an object with any of the following:
			// {
			// 	'fontSize': 12
			// 	, 'fontStyle': 'Italic'
			// 	, 'fontName': 'Times'
			// }
			// Without these, .splitTextToSize will use current / default
			// font Family, Style, Size.
			console.log(lines);
			pdf.text(0.5, verticalOffset + size / 72, lines)

			verticalOffset += (lines.length + 0.5) * size / 72
		}
	}

	pdf.save('Test.pdf');
}

function demoFromHTML() {
	var pdf = new jsPDF('p', 'pt', 'letter')

	// source can be HTML-formatted string, or a reference
	// to an actual DOM element from which the text will be scraped.
	, source = $('#fromHTMLtestdiv')[0]

	// we support special element handlers. Register them with jQuery-style 
	// ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
	// There is no support for any other type of selectors 
	// (class, of compound) at this time.
	, specialElementHandlers = {
		// element with id of "bypass" - jQuery style selector
		'#bypassme': function(element, renderer){
			// true = "handled elsewhere, bypass text extraction"
			return true
		}
	}

	margins = {
      top: 80,
      bottom: 60,
      left: 40,
      width: 522
    };
    // all coords and widths are in jsPDF instance's declared units
    // 'inches' in this case
    pdf.fromHTML(
    	source // HTML string or DOM elem ref.
    	, margins.left // x coord
    	, margins.top // y coord
    	, {
    		'width': margins.width // max width of content on PDF
    		, 'elementHandlers': specialElementHandlers
    	},
    	function (dispose) {
    	  // dispose: object with X, Y of the last line add to the PDF 
    	  //          this allow the insertion of new lines after html
          pdf.save('Test.pdf');
        },
    	margins
    )
}

function demoTextAlign() {
	var pdf = new jsPDF('p', 'pt', 'letter');
	
	pdf.setFillColor(0);
	pdf.circle( 140, 50, 2, "F" );
	pdf.text( 'This text is normally\raligned.', 140, 50 );
	
	pdf.circle( 140, 120, 2, "F" );
	pdf.text( 'This text is centered\raround\rthis point.', 140, 120, 'center' );
	
	pdf.circle( 140, 300, 2, "F" );
	pdf.text( 'This text is rotated\rand centered around\rthis point.', 140, 300, 45, 'center' );
	
	pdf.circle( 140, 400, 2, "F" );
	pdf.text( 'This text is\raligned to the\rright.', 140, 400, 'right' );
	
	pdf.circle( 140, 550, 2, "F" );
	pdf.text( 'This text is\raligned to the\rright.', 140, 550, 45, 'right' );
	
	pdf.circle( 460, 50, 2, "F" );
	pdf.text( 'This single line is centered', 460, 50, 'center' );

	pdf.circle( 460, 200, 2, "F" );
	pdf.text( 'This right aligned text\r\rhas an empty line.', 460, 200, 'right' );
	
	
	pdf.save('Test.pdf');
}