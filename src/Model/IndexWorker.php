<?php
/**
 * @author Manuele Menozzi <mmenozzi@webgriffe.com>
 */

class Webgriffe_IndexQueue_Model_IndexWorker extends Lilmuckers_Queue_Model_Worker_Abstract
{
    public function run(Lilmuckers_Queue_Model_Queue_Task $task)
    {
        try {
            /** @var Webgriffe_IndexQueue_Model_Indexer $indexer */
            $indexer = Mage::getModel('index/indexer');

            $taskData = $task->getData();
            $entityClass = $taskData['entityClass'];
            $entityData = $taskData['entityData'];
            $entityOrigData = $taskData['entityOrigData'];

            /** @var Varien_Object $entity */
            $entity = new $entityClass($entityData);
            if ($entity->getId() && method_exists($entity, 'load')) {
                $id = $entity->getId();
                $entity = new $entityClass();
                $entity->load($id);
            } else {
                //Is this needed? This data was already passed to the constructor earlier...
                $entity->setData($entityData);
            }

            if ($entity instanceof Mage_Catalog_Model_Category) {
                //In some cases, such as when changing the positions for some products in a category, there may be
                //one or more _data values that are not set by a load() call. Specifically for a category there are
                //the posted_products, is_changed_product_list, products_position, affected_product_ids items and
                //more. If these values are missing, some reindex operations may not be ferformed, such as updating
                //the catalog_category_product index when changing product positions.
                //To solve this, re-set the missing values before proceeding with the reindex.
                $keysToRestore = array(
                    'id',
                    'default_sort_by',
                    'posted_products',
                    'path_ids',
                    'custom_design_from_is_formated',
                    'custom_design_to_is_formated',
                    'is_changed_product_list',
                    'products_position',
                    'affected_product_ids',
                );

                $entity->addData(array_intersect_key($entityData, array_combine($keysToRestore, $keysToRestore)));
            }

            if ($entityOrigData && is_array($entityOrigData)) {
                foreach ($entityOrigData as $key => $data) {
                    $entity->setOrigData($key, $data);
                }
            }
            $entityType = $taskData['entityType'];
            $eventType = $taskData['eventType'];

            if ($taskData['allowTableChanges']) {
                $indexer->allowTableChanges();
            } else {
                $indexer->disallowTableChanges();
            }

            if ($entity->getId()) {
                $this->log('Starting reindex for object '.get_class($entity).' with id '.$entity->getId());
            } else {
                $this->log('Starting reindex for object '.get_class($entity).' without id');
            }

            $indexer->processEntityActionByWorker($entity, $entityType, $eventType);

            $this->log('Indexing Done');

            $task->success();
        } catch (Exception $e) {
            $this->log('Index Worker exception: ' . $e->getMessage(), Zend_Log::CRIT);
            $this->log($e->getTraceAsString(), Zend_Log::CRIT);

            //Rethrow the exception to allow Lilmuckers_Queue_Model_Queue_Task to properly handle it
            throw $e;
        }
    }

    /**
     * @param string $message
     * @param int $level
     */
    protected function log($message, $level = Zend_Log::DEBUG)
    {
        Mage::helper('wg_indexqueue')->log($message, $level);
    }
}
