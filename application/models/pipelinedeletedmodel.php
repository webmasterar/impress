<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *
 * Copyright 2014 Medical Research Council Harwell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

/**
 * Pipeline Deleted model
 */
class PipelineDeletedModel extends CI_Model implements IUserIdCheckable, IRecyclable
{
    const TABLE = 'pipeline_deleted';
    const PRIMARY_KEY = 'id';

    public function fetchAll()
    {
        return $this->db->select('del.*, user.name AS username')
                        ->from(self::TABLE . ' AS del')
                        ->join($this->config->item('mousephenotypedb') . '.users user', 'user.uid = del.user_id', 'left')
                        ->order_by('del.time_modified', 'desc')
                        ->order_by('del.user_id')
                        ->get()
                        ->result_array();
    }

    public function getById($id)
    {
        return $this->db->from(self::TABLE)
                        ->where(self::PRIMARY_KEY, $id)
                        ->limit(1)
                        ->get()
                        ->row_array();
    }

    private function _filterFields($arr)
    {
        $this->load->helper('keep_array_keys');
        $this->load->helper('delete_array_values');
        $keys = delete_array_values($this->pipelinemodel->getFields(), 'deleted');
        return keep_array_keys($arr, $keys);
    }

    public function getByPipelineId($pid)
    {
        return $this->db->from(self::TABLE)
                        ->where('pipeline_id', $pid)
                        ->order_by('weight')
                        ->get()
                        ->result_array();
    }

    public function purgeRecord($id)
    {
        $this->db->where(self::PRIMARY_KEY, $id)
                 ->delete(self::TABLE);
        return $this->db->affected_rows();
    }

    /**
    * @alias
    * @see PipelineDeletedModel::purgeRecord()
    */
    public function permanentlyDelete($id)
    {
        return $this->purgeRecord($id);
    }

    /**
    * @param int|array $record either the id of a record in the pipeline table
    * or an array of the record fields
    * @return int|bool insert id or false on failure
    */
    public function insert($record)
    {
        if (is_numeric($record)) {
            $record = $this->pipelinemodel->getById($record);
        }

        if(empty($record))
            return false;

        $record['time_modified'] = $this->config->item('timestamp');
        $record['user_id'] = User::getId();
        $this->db->insert(self::TABLE, $this->_filterFields($record));
        return $this->db->insert_id();
    }

    /**
    * Restores/Undeletes the deleted record
	* @override
    * @param int $deletedRecordId
    * @param array $origin
    * @return int|bool insert id or false on failure
    */
    public function restore($deletedRecordId, array $origin = array())
    {
        //fetch the deleted record
        $deletedRecord = $this->getById($deletedRecordId);
        if(empty($deletedRecord) || empty($origin))
            return false;

        //prepare the record for restoration
        unset($deletedRecord['id']);
        $deletedRecord['user_id'] = User::getId();
        $deletedRecord['time_modified'] = $this->config->item('timestamp');

        //check the destination id has not been reoccupied,
        //otherwise insert into a new destination
        // $rec = $this->pipelinemodel->getById($deletedRecord['pipeline_id']);
        // if( ! empty($rec))
            // $deletedRecord['pipeline_id'] = null;
        $iid = $this->pipelinemodel->insert($deletedRecord, ChangeLogger::ACTION_UNDELETE);

        //purge the record from the deleted table as it has now been restored
        if($iid)
            $this->purgeRecord($deletedRecordId);

        return $iid;
    }
	
    /**
    * @override
    * @see IRecyclable::getRecyclableFields()
    */
    public static function getRecyclableFields()
    {
        return array(
            static::R_ID => self::PRIMARY_KEY,
            static::R_NAME => 'name',
            static::R_DATE => static::R_DATE,
            static::R_USER => static::R_USER,
            static::R_FIELDS => array('pipeline_key')
        );
    }
}
