<?php

use yii\db\Migration;

/**
 * Handles the creation for table `{{%ceramic_collection_map}}`.
 */
class m190808_100056_create_table_ceramic_collection_map extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableExist = $this->db->getTableSchema("{{%ceramic_collection_map}}", true);
        if ($tableExist) {
            return true;
        }

        $this->createTable('{{%ceramic_collection_map}}', [

            'id' => $this->primaryKey()->notNull(),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'collection_id' => $this->integer(11)->notNull(),
            'product_id' => $this->integer(11)->notNull()
        ]);

        $this->createIndex(
            'ceramic_collection_map_unique',
            '{{%ceramic_collection_map}}',
            ['collection_id', 'product_id'],
            true
        );

        // creates index for column `created_by`
        $this->createIndex(
            'ceramic_collection_map_created_by',
            '{{%ceramic_collection_map}}',
            'created_by'
        );

        // add foreign key for table `cms_user`
        $this->addForeignKey(
            'ceramic_collection_map__created_by',
            '{{%ceramic_collection_map}}',
            'created_by',
            '{{%cms_user}}',
            'id',
            'SET NULL', 'SET NULL'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            'ceramic_collection_map_updated_by',
            '{{%ceramic_collection_map}}',
            'updated_by'
        );

        // add foreign key for table `cms_user`
        $this->addForeignKey(
            'ceramic_collection_map__updated_by',
            '{{%ceramic_collection_map}}',
            'updated_by',
            '{{%cms_user}}',
            'id',
            'SET NULL', 'SET NULL'
        );

        // creates index for column `collection_id`
        $this->createIndex(
            'ceramic_collection_map_collection_id',
            '{{%ceramic_collection_map}}',
            'collection_id'
        );

        // add foreign key for table `cms_content_element`
        $this->addForeignKey(
            'ceramic_collection_map__collection_id',
            '{{%ceramic_collection_map}}',
            'collection_id',
            '{{%cms_content_element}}',
            'id',
            'CASCADE','CASCADE'
        );

        // creates index for column `product_id`
        $this->createIndex(
            'ceramic_collection_map_product_id',
            '{{%ceramic_collection_map}}',
            'product_id'
        );

        // add foreign key for table `cms_content_element`
        $this->addForeignKey(
            'ceramic_collection_map__product_id',
            '{{%ceramic_collection_map}}',
            'product_id',
            '{{%cms_content_element}}',
            'id',
            'CASCADE','CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // drops foreign key for table `cms_user`
        $this->dropForeignKey(
            'ceramic_collection_map__created_by',
            '{{%ceramic_collection_map}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            'ceramic_collection_map_created_by',
            '{{%ceramic_collection_map}}'
        );

        // drops foreign key for table `cms_user`
        $this->dropForeignKey(
            'ceramic_collection_map__updated_by',
            '{{%ceramic_collection_map}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            'ceramic_collection_map_updated_by',
            '{{%ceramic_collection_map}}'
        );


        // drops foreign key for table `cms_content_element`
        $this->dropForeignKey(
            'ceramic_collection_map__product_id',
            '{{%ceramic_collection_map}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            'ceramic_collection_map_product_id',
            '{{%ceramic_collection_map}}'
        );

        // drops foreign key for table `cms_content_element`
        $this->dropForeignKey(
            'ceramic_collection_map__collection_id',
            '{{%ceramic_collection_map}}'
        );

        // drops index for column `collection_id`
        $this->dropIndex(
            'ceramic_collection_map_collection_id',
            '{{%ceramic_collection_map}}'
        );

        $this->dropTable('{{%ceramic_collection_map}}');
    }
}
