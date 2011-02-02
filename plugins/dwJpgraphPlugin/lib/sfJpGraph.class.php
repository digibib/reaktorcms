<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Dustin Whittle <dustin.whittle@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * sfJpGraph class.
 *
 * This class provides an abstraction layer to the PHP FPDF library Provides
 * creation/modification of pdf files.
 *
 * @package    symfony
 * @subpackage dwJgraphPlugin
 * @author     Dustin Whittle <dustin.whittle@symfony-project.com>
 * @author     Jordi Backx <jordi@westsitemedia.nl>
 * @version    SVN: $Id: sfJpGraph.class.php 6910 2008-01-03 07:03:55Z dwhittle $
 * @todo       autoload libraries + more graphs + docs
 */

require_once('jpgraph/jpgraph.php');

class sfJpGraph
{

  /**
   * The actual jpgraph object. Is returned by getJpGraphObject() to be used in a
   * symfony action method
   */
  private $JpGraph;

  /**
   * Contsructor
   *
   * @param string graph type. Can be combination of comma separated types
   * @param int width of the graph canvas
   * @param int height of the graph canvas
   * @param string cached name of the graph (see JpGraph docs)
   * @param int timeout (see JpGraph docs)
   * @param bool inline (or not, see JpGrpah docs)
   */
  public function __construct($type = 'bar', $width = 300, $height = 200, $cached_name = '', $time_out = 0, $inline = true,  $barcode_type = null)
  {

    /*
     * Some types used their own class, default is Graph, however
     */
    switch ($type)
    {

      case 'pie3D':

        require_once('jpgraph/jpgraph_pie.php');
        require_once('jpgraph/jpgraph_pie3d.php');

        $this->JpGraph = new PieGraph($width, $height, $cached_name, $time_out, $inline);

      break;

      case 'pie':

        require_once('jpgraph/jpgraph_pie.php');
        $this->JpGraph = new PieGraph($width, $height, $cached_name, $time_out, $inline);

      break;

      case 'polar':

        require_once('jpgraph/jpgraph_polar.php');
        $this->JpGraph = new PolarGraph($width, $height, $cached_name, $time_out, $inline);

      break;

      case 'radar':

        require_once('jpgraph/jpgraph_radar.php');
        $this->JpGraph = new RadarGraph($width, $height, $cached_name, $time_out, $inline);

      break;

      case 'canvas':

        require_once('jpgraph/jpgraph_canvas.php');
        $this->JpGraph = new CanvasGraph($width, $height, $cached_name, $time_out, $inline);

      break;

      case 'gantt':

        require_once('jpgraph/jpgraph_gantt.php');
        $this->JpGraph = new GanttGraph($width, $height, $cached_name, $time_out, $inline);

      break;

      case 'mgraph':

        require_once('jpgraph/jpgraph_mgraph.php');
        $this->JpGraph = new MGraph($width, $height, $cached_name, $time_out, $inline);

      break;

      case 'barcode':

        require_once('jpgraph_canvas.php');
        require_once('jpgraph_barcode.php');

        switch ($barcode_type)
        {
            case 'EAN-8' :
              $symbology = BarcodeFactory::Create(ENCODING_EAN8);
            break;
            case 'EAN-13' :
              $symbology = BarcodeFactory::Create(ENCODING_EAN13);
            break;

            case 'EAN-128' :
              $symbology = BarcodeFactory::Create(ENCODING_EAN128);
            break;

            case 'UPC-A' :
              $symbology = BarcodeFactory::Create(ENCODING_UPCA);
            break;

            case 'UPC-E' :
              $symbology = BarcodeFactory::Create(ENCODING_UPCE);
            break;

            case 'CODE-11' :
              $symbology = BarcodeFactory::Create(ENCODING_CODE11);
            break;

            case 'CODE-25' :
              $symbology = BarcodeFactory::Create(ENCODING_CODE25);
            break;

            case 'CODE-39' :
              $symbology = BarcodeFactory::Create(ENCODING_CODE39);
            break;

            case 'CODE-93' :
              $symbology = BarcodeFactory::Create(ENCODING_CODE93);
            break;

            case 'CODE-128' :
              $symbology = BarcodeFactory::Create(ENCODING_CODE128);
            break;

            case 'POSTNET' :
              $symbology = BarcodeFactory::Create(ENCODING_POSTNET);
            break;

            case 'CODEI25' :
              $symbology = BarcodeFactory::Create(ENCODING_CODEI25);
            break;

            case 'CODABAR' :
              $symbology = BarcodeFactory::Create(ENCODING_CODABAR);
            break;

            case 'BOOKLAND' :
              $symbology = BarcodeFactory::Create(ENCODING_BOOKLAND);
            break;
          }

          $this->JpGraph = BackendFactory::Create(BACKEND_IMAGE, $symbology);
          $this->JpGraph->setHeight($height);
          $this->JpGraph->AddChecksum();

      break;

      default:

        $this->JpGraph = new Graph($width, $height, $cached_name, $time_out, $inline);
        $this->JpGraph->SetScale('textlin');

      break;
    }

  }

  /**
   * Return the JpGraph object for manipulation in action
   *
   * @return object JpGraph object
   */
  public function getJpGraph()
  {
      return $this->JpGraph;
  }

}

?>
