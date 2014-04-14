<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
    <html>
  <head><link rel="stylesheet" href="css/table.css" type="text/css"/></head>
  <body>
    <table border="1">
    <tr class="heading">
      <th align="left">App Name</th>
      <th align="left">Total Liked</th>
    </tr>
    <xsl:for-each  select="apps/app">
        <xsl:sort select="count(liked)" data-type="number" order="ascending" />
        <xsl:if test="position() &lt;= 10">
            <tr>
                <td><xsl:value-of select="name" /></td>
                <td><xsl:value-of select="liked"/></td>
            </tr>
        </xsl:if>
    </xsl:for-each>
    </table>
     </body>
  </html>
</xsl:template>

</xsl:stylesheet>
