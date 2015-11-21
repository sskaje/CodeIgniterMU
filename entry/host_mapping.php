<?php
/**
 * CodeIgniter MUltiple Site Host Mapping Configurations
 *
 * CodeIgniter MUltiple Site
 * A multiple-site solution for CodeIgniter
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2015 - , sskaje
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniterMU
 * @author	sskaje
 * @copyright	Copyright (c) 2015 - , sskaje (http://sskaje.me/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */

$host_mapping = [
    'production'  => [
        'www.sskaje.me'      => 'www.sskaje.me',
    ],
    'development' => [
        'm.sskaje.*'         => 'm.sskaje.me',
        'm.*.sskaje.*'       => 'm.sskaje.me',

        'default'            => 'www.sskaje.me',
    ],
];

return $host_mapping;

# EOF
