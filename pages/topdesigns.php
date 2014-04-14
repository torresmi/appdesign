<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="./css/table.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<h1>Top App Designs</h1>
</head>
 
  <script>
        var xmlHttp = createXmlHttpRequestObject();
        var xml;
        var xsl;
        
    // get the ajax variable
      function createXmlHttpRequestObject() {
            if (window.ActiveXobject) {
                try {
                    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                } catch(e) {
                    xmlHttp = false;
                }
            } else {
                try {
                    xmlHttp = new XMLHttpRequest();
                } catch(e) {
                    xmlHttp = false;
                }
            }
            
            if (!xmlHttp) {
                alert("error");
            } else {
                return xmlHttp;
            }
        }
        
        
        // Get the info 
        function ajaxFirstScript() {
        
            if (xmlHttp.readyState==0 || xmlHttp.readyState==4) {
                xmlHttp.open("GET", "scripts/topapps.php", true); 
                xmlHttp.onreadystatechange = handleServerResponse;
                xmlHttp.send(null);
            } else {
                setTimeout(function() {
                    ajaxFirstScript();
                    }, 1000);
            }
        }
        
        function loadXMLDoc(filename) {
            if (window.XMLHttpRequest)
              {
              xhttp=new XMLHttpRequest();
              }
            else // code for IE5 and IE6
              {
              xhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xhttp.open("GET",filename,false);
            xhttp.send();
            return xhttp.responseXML;
        }
        
        // Handle the response from the  ajax call
        function handleServerResponse() {
            if (xmlHttp.readyState==4) {
                if (xmlHttp.status==200) {         
                    xml = loadXMLDoc("scripts/result.xml");
                    xsl = loadXMLDoc("scripts/style.xsl")
                    displayResult();    
                }
            }
        }
        
        // Display the table of clients
        function displayResult() {
             if (xmlHttp.readyState==4) {
                if (xmlHttp.status==200) {  
                    
                    console.log(xsl);
                    console.log(xml);
                    // If this is null then parse it from the string
                    if (!xsl) {
                        xsl = (new DOMParser()).parseFromString(xmlHttp.responseText, 'text/xml');
                    }
                    
                    // code for Chrome, Firefox, Opera, etc.
                    if (document.implementation && document.implementation.createDocument) {
                        xsltProcessor = new XSLTProcessor();
                        xsltProcessor.importStylesheet(xsl);
                        resultDocument = xsltProcessor.transformToFragment(xml, document);
                        console.log(resultDocument);
                        var table = document.getElementById("tableDiv");
                        
                        // Replace a table if one already exists
                        if (table.childNodes.length > 0) {
                        
                            // Iterate through all the child elements and remove them
                            while (table.firstChild) {
                                table.removeChild(table.firstChild);
                            }
                            
                            table.appendChild(resultDocument);
                        } else {
                            table.appendChild(resultDocument);
                        }
                        
                    }
                }
            }
        }
        
        

    </script>

<body onload="ajaxFirstScript()">
    <div id="tableDiv"></div>
</body>
</html>
