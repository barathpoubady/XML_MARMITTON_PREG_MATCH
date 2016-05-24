<?xml version="1.0" encoding="ISO-8859-1"?>
<!-- Edited by XMLSpy? -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:template match="/">
    <html>
    <body>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
      <tr>
        <th style="text-align:center; color:#000000; text-transform:uppercase; font-family:Arial, Helvetica, sans-serif;" height="50">Recette</th>
      </tr>
      <xsl:for-each select="copieMarmitton/Recette">
      <tr>
        <td>
         <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
           <tr>
             <td bgcolor="#FFFFFF" width="10%" style="border-right:1px solid #333;">
                  
             </td>
             <td colspan="4" width="80%" height="100" align="center" valign="middle" style="border-top:1px #333 solid;">
               <h3><xsl:value-of select="titre"/></h3>
             </td>
             <td bgcolor="#FFFFFF" width="10%" style="border-left:1px solid #333;">
                  
             </td>
           </tr>
     			 <tr>
             <td bgcolor="#FFFFFF" width="10%" style="border-right:1px solid #333;">
                  
             </td>
             <td bgcolor="#FFFFFF" width="1%">
                  
             </td>
          	 <td width="29%" align="left" valign="middle">
              <img>
                <xsl:attribute name="width">30%</xsl:attribute>
                <!--<xsl:attribute name="height">30%</xsl:attribute>-->
                <xsl:attribute name="src"><xsl:value-of select="image"/></xsl:attribute>
              </img>
          	 </td>
             <td width="49%" bgcolor="#90DFF4" style="font-family:Arial, Helvetica, sans-serif;"> 
             		Temps de préparation : <xsl:value-of select="tempPrepartion"/> <br/>
                Temps de cuisson : <xsl:value-of select="tempCuisson"/>
             </td>
             <td bgcolor="#FFFFFF" width="1%">
                  
             </td>
             <td bgcolor="#FFFFFF" width="10%" style="border-left:1px solid #333;">
                  
             </td>
            </tr>
           </table>
         </td>
       </tr>
       <tr>
         <td>
          <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
     			 <tr>
             <td bgcolor="#FFFFFF" width="10%" style="border-right:1px solid #333;">
                  
             </td>
             <td bgcolor="#FFFFFF" width="1%">
                  
             </td>
             <td width="78%">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <xsl:for-each select="tableIngredients/ingredients">
                    <tr bgcolor="#FFF">
                       <xsl:if test="position()=1">
                         <td width="100%" height="30" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:14px;">
                            <strong><xsl:value-of select="."/></strong>
                          </td>
                      </xsl:if>
                       <xsl:if test="position()!=1">
                         <td width="100%" height="25" bgcolor="#cccccc" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#000000;">
                             <xsl:value-of select="."/>
                          </td>
                      </xsl:if>
                    </tr>
                   </xsl:for-each>
                  </table>
                </td>
                <td bgcolor="#FFFFFF" width="1%">
                  
                 </td>
                 <td bgcolor="#FFFFFF" width="10%" style="border-left:1px solid #333;">
                      
                 </td>
                </tr>
              </table>
          </td>
        </tr>
        <tr>
         <td>
          <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
     			 <tr>
             <td bgcolor="#FFFFFF" width="10%" style="border-right:1px solid #333;">
                  
             </td>
             <td bgcolor="#FFFFFF" width="1%" style="border-bottom:1px #333 solid;">
                  
             </td>
             <td width="78%" style="border-bottom:1px #333 solid;">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <xsl:for-each select="tablePreparation/preparation">
                  <tr bgcolor="#FFF">
                    <xsl:if test="position()=1">
                         <td width="100%" height="30" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:14px;">
                            <strong><xsl:value-of select="."/></strong>
                          </td>
                      </xsl:if>
                       <xsl:if test="position()!=1">
                         <td width="100%" height="10" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding-left:10px; padding-top:5px;">
                              <xsl:value-of select="."/>
                          </td>
                      </xsl:if>
                  </tr>
                 </xsl:for-each>
             	 </table>
                </td>
                 <td bgcolor="#FFFFFF" width="1%" style="border-bottom:1px #333 solid;">
                  
                 </td>
                 <td bgcolor="#FFFFFF" width="10%" style="border-left:1px solid #333;">
                      
                 </td>
                </tr>
              </table>
          </td>
        </tr>
        <tr>
         <td>
          <br/><br/>
         </td>
       </tr>
      </xsl:for-each>
    </table>
    </body>
    </html>
  </xsl:template>
</xsl:stylesheet>