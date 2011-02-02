<?php
/**
 * Custom 500 error page
 *
 * @author    Hannes Magnusson <bjori@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 *
 *  Internal Error 500
 *
 *  The server encountered an unexpected condition which prevented it from 
 *  fulfilling the request.
 *
 * Note the "prevented it from fulfilling the request" part. We cannot use stuff 
 * from synfony here as it may or may not have managed to initialize anything.
 *
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="title" content="Reaktor" />
  <meta name="robots" content="index, follow" />
  <meta name="description" content="Description of Reaktor" />
  <title>Reaktor: Internal error</title>

  <link rel="shortcut icon" href="/reakfavicon.ico" />

  <link rel="stylesheet" type="text/css" media="all" href="/css/main.css" />
  <link rel="stylesheet" type="text/css" media="all" href="/css/layout.css" />
</head>

<body>
<div id = "wrapper">
  <div id = "header_block">
    <img id="header_image" usemap="#forsidemap" border="0" src="/images/logoForside.gif" alt="LogoForside" />
    <map name="forsidemap" id = "foresidemap">
      <area shape="rect" coords="0,0,166,38" href="/" title="Home" alt="Home" />
      <area shape="rect" coords="178,12,213,38" href="/foto" title="FotoReaktor" alt="FotoReaktor" />
      <area shape="rect" coords="215,13,260,38" href="/tegning" title="TegningReaktor" alt="TegningReaktor" />

      <area shape="rect" coords="261,13,296,38" href="/film" title="FilmReaktor" alt="FilmReaktor" />
      <area shape="rect" coords="300,13,336,38" href="/lyd" title="LydReaktor" alt="LydReaktor" />
      <area shape="rect" coords="340,13,375,38" href="/tegneserier" title="TegneserieReaktor" alt="TegneserieReaktor" />
      <area shape="rect" coords="378,13,408,38" href="/tekst" title="TekstReaktor" alt="TekstReaktor" />
    </map>
  </div>
  <div id="menu_bar">
    <a href="/">Home / hjem</a>
  </div>
  <div id="content" style="height:300px">
    <div id="content_main">
      <div id="error500" style="margin: 50px;">
        <div style="margin: 10px">
          <p>We are sorry, but there was an error trying to show the page you have requested.</p>
          <p>Please try again later.</p>
          <p>If the problem persists, please contact <a href="mailto:deichman@minreaktor.no">deichman@minreaktor.no</a></p>
          <p style="float:right"><a href="javascript:history.back(-1)">(Go back)</a></p>
        </div>
        <hr />
        <div style="margin: 10px">
          <p>Beklager, det oppstod en feil ved visning av siden.</p>
          <p>Vennligst prøv igjen senere.</p>
          <p>Hvis problemet fortsetter, vennligst kontakt <a href="mailto:deichman@minreaktor.no">deichman@minreaktor.no</a></p>
          <p style="float:right"><a href="javascript:history.back(-1)">(Gå tilbake)</a></p>
        </div>
        <hr />
      </div>
    </div>
  </div>
  <hr class="bottom_line" /><br class="clear" /><br /><br /><br /><br />

  <p>
  <a href="http://www.deichman.no"><img alt="Deichmanske bibliotek" title="Deichmanske bibliotek" src="/images/logoDeichman.gif" /></a>
  <a href="http://www.tfb.no"><img alt="Trondheim folkebibliotek" title="Trondheim folkebibliotek" src="/images/logoTrheim.gif" /></a>
  <a href="http://www.norskdigitaltbibliotek.no"><img alt="Norsk digitalt bibliotek" title="Norsk digitalt bibliotek" src="/images/logoNDB.gif" /></a>
  <a href="http://www.kulturnett.no"><img alt="Kulturnett.no" title="Kulturnett.no" src="/images/logoKN.gif" /></a> 
  </p>

  <hr class = "bottom_line" /><br />
</div>

</div>
</div>
</html>

