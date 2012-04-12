How to Install
==============
  1. Download TCPDF library at http://sourceforge.net/projects/tcpdf/files/
      and put it in vendor folder

  2. Add this bundle to your vendor/ dir
    * Vendor Mode
      Add the following lines in your deps file::

        [IoTcpdfBundle]
        git=git://github.com/ioalessio/IoTcpdfBundle.git
        target=/bundles/Io/TcpdfBundle


      Run the vendor script:

        ./bin/vendors install


  3. Add the "Io" namespace to your autoloader:

        // app/autoload.php
        $loader->registerNamespaces(array(
        'Io' => __DIR__.'/../vendor/bundles',
        // your other namespaces
        ));

        //in same file include tcpdf library
        require_once __DIR__.'/../vendor/tcpdf/tcpdf.php';


  4. Add the "Io" namespace to your kernel:

        // app/ApplicationKernel.php
        public function registerBundles()
        {
            return array(
                // ...
                new Io\TcpdfBundle\IoTcpdfBundle(),
                // ...
            );
        }



HOW TO USE:
==============

      //in mybundle/controllers/myController.php

        class MyController extends Controller
        {
            /**
             * @Route("/mypage.pdf")
             */
            public function mypageAction()
            {
                $html = $this->renderView('MyBundle:MyController:mypage.pdf.twig', array());

                //io_tcpdf will returns Response object
                return $this->get('io_tcpdf')->quick_pdf($html);
            }
        }

     //in mybundle/Resources/views/myController.pdf.twig

          put here your html code


TODO
============

 * smart method for easier PDF generation and customization
 * cache pdf generation
 * @PDF('template.twig') annotation system