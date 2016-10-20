<?xml version='1.0'?>
<xsl:stylesheet version='1.0' xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html"/>

	<xsl:template match="/goodsList">
		<xsl:choose>
			<xsl:when test="(count(good[@available&gt;0])&gt;0)">
				<xsl:apply-templates select="good[@available &gt; 0]"/>
			</xsl:when>
			<xsl:otherwise>
				<tr><td>No available products found</td></tr>
			</xsl:otherwise>
		</xsl:choose>	
	</xsl:template>
	
	<xsl:template match="good">
		<tr>
			<td><xsl:value-of select="itemNum"/></td>
			<td><xsl:value-of select="name"/></td>
            <td><xsl:value-of select="substring(description,0,20)"/>...</td>
			<td>$<xsl:value-of select="unitPrice"/></td>
			<td><xsl:value-of select="@available"/></td>
            <td><input type="button" value="Add one to cart" class="addTocartButton"/></td>
		</tr>
	</xsl:template>

</xsl:stylesheet>

