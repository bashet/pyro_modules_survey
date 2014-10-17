#Survey Module for IOE

To get pdf output
----------------------------
<pre>wkhtmltopdf http://www.google.com google.pdf</pre>

To install wkHTMLtoPDF
------------------------------
<pre>wget http://wkhtmltopdf.googlecode.com/files/wkhtmltopdf-0.9.9-static-amd64.tar.bz2</pre>
<pre>tar xvjf wkhtmltopdf-0.9.9-static-amd64.tar.bz2</pre>
<pre>mv wkhtmltopdf-amd64 /usr/bin/wkhtmltopdf</pre>
<pre>chmod 777 /usr/bin/wkhtmltopdf</pre>


chmod 777 -R addons/ assets/ system/cms/logs/ system/cms/cache/ uploads/ reports/
