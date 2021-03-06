<?php
/**
 * File containing the ezcWebdavKonquerorCompatibleTransport class.
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package Webdav
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
/**
 * Transport layer for the Konqueror web browser (KDE).
 *
 * This transport class adjust the behavior of the Webdav component to work
 * with the KDE browser Konqueror.
 *
 * Tested with:
 *
 * - Konqueror 3.5.7
 * - Konqueror 3.5.9 (does not perform PUT requests, bug in client)
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavKonquerorCompatibleTransport extends ezcWebdavTransport
{
    /**
     * Decodes the URLs in href attributes of PROPFIND responses.
     *
     * Konqueror does not use the <displayname> property (which is also URL
     * encoded), but the <href> tag of the response to determine the displayed
     * resource names. It expects the content to be un-encoded.
     *
     * This method calls the parent method and replaces the content of all
     * <href> elements in the DOM tree.
     * 
     * @param ezcWebdavPropFindResponse $response 
     * @return ezcWebdavXmlDisplayInformation
     */
    protected function processPropFindResponse( ezcWebdavPropFindResponse $response )
    {
        $xmlDisplayInfo = parent::processPropFindResponse( $response );
        $hrefElements = $xmlDisplayInfo->body->getElementsByTagName( 'href' );

        foreach ( $hrefElements as $href )
        {
            $href->nodeValue = urldecode( $href->nodeValue );
        }
        return $xmlDisplayInfo;
    }

    /**
     * Returns display information for a error response object.
     *
     * When receiving 'HTTP/1.1 404 Not Found', Konqueror (versions 3.5.8 and up)
     * requires a body. Normally the processErrorResponse functions does not
     * return a body for 404 messages, so this override method sets a body
     * for Konqueror.
     *
     * @param ezcWebdavErrorResponse $response 
     * @param bool $xml DOMDocument in result only generated of true.
     * @return ezcWebdavXmlDisplayInformation|ezcWebdavEmptyDisplayInformation
     */
    protected function processErrorResponse( ezcWebdavErrorResponse $response, $xml = false )
    {
        if ( $response->status === 404 )
        {
            $response->responseDescription = '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
                <html><head>
                <title>404 Not Found</title>
                </head><body>
                <h1>Not Found</h1>
                <p>The requested URL was not found on this server.</p>
                <hr>
                </body></html>';
        }

        $xmlDisplayInfo = parent::processErrorResponse( $response, $xml );
        return $xmlDisplayInfo;
    }
}
?>
