Webgriffe IndexQueue Magento Extension
======================================

[![Build Status](https://travis-ci.org/webgriffe/index-queue-extension.svg?branch=master)](https://travis-ci.org/webgriffe/index-queue-extension)

This Magento extension queues indexing operations with a queue manager backend. It's based on [Lilmuckers_Queue](https://github.com/lilmuckers/magento-lilmuckers_queue) extension.

Installation
------------

Add the extension to your `composer.json` or install it with [modman](https://github.com/colinmollenhour/modman).
After you should set up queue backend. For example, to use **[Beanstalk](http://kr.github.io/beanstalkd/)** merge this in your `local.xml`:

```xml
<?xml version="1.0"?>
<config>
    <global>

        <queue>
            <backend>beanstalkd</backend>
            <beanstalkd>
                <servers>
                    <server>
                        <host>127.0.0.1</host>
                    </server>
                </servers>
            </beanstalkd>
        </queue>

    </global>

</config>
```

Usage
-----

After installation all indexing operations are automatically queued. You can disable this behavior in _System -> Configuration -> System -> Index Queue_. To process queued indexing tasks you have to start queue watching by workers. To do that, as stated in [Lilmuckers_Queue](https://github.com/lilmuckers/magento-lilmuckers_queue) extension documentation, run the following commands:

	$ cd /path/to/magento/shell
	$ php queue.php --watch

Contributing
------------

Please, contribute! Clone this repository, customize your parameters and then use provided continuous integration script to install Magento and run tests.

	$ cd /some/path
	$ git clone git@github.com:webgriffe/index-queue-extension.git
	$ cd index-queue-extension/
	$ cp params.sh.dist params.sh

Customize parameters in `params.sh` file. Then run:

	$ ./ci.sh
	
This will installs Magento in `magento` directory and then will run tests with [EcomDev_PHPUnit](https://github.com/EcomDev/EcomDev_PHPUnit).

Credits
-------

This extension has been developed by [Webgriffe®](http://www.webgriffe.com/). Please, report to us any bug or suggestion by GitHub issues.