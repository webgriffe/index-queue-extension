Webgriffe IndexQueue Magento Extension
======================================

[![Build Status](https://travis-ci.org/webgriffe/index-queue-extension.svg?branch=master)](https://travis-ci.org/webgriffe/index-queue-extension)

This Magento extension queues indexing operations with a queue manager backend. It's based on Lilmuckers_Queue extension
(https://github.com/lilmuckers/magento-lilmuckers_queue).

Installation
------------

Add the extension to your composer.json or install it with modman.
After you should set up queue backend. For example, to use Beanstalk merge this in your local.xml:

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