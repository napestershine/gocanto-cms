<?php
 if (!defined('BASEPATH')) {
     exit('No direct script access allowed');
 }
/**
 * CodeIgniter.
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 *
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * SQLSRV Result Class.
 *
 * This class extends the parent result class: CI_DB_result
 *
 * @category	Database
 *
 * @author		ExpressionEngine Dev Team
 *
 * @link		http://codeigniter.com/user_guide/database/
 */
class CI_DB_sqlsrv_result extends CI_DB_result
{
    /**
     * Number of rows in the result set.
     *
     * @return int
     */
    public function num_rows()
    {
        return @sqlsrv_num_rows($this->result_id);
    }

    // --------------------------------------------------------------------

    /**
     * Number of fields in the result set.
     *
     * @return int
     */
    public function num_fields()
    {
        return @sqlsrv_num_fields($this->result_id);
    }

    // --------------------------------------------------------------------

    /**
     * Fetch Field Names.
     *
     * Generates an array of column names
     *
     * @return array
     */
    public function list_fields()
    {
        $field_names = [];
        foreach (sqlsrv_field_metadata($this->result_id) as $offset => $field) {
            $field_names[] = $field['Name'];
        }

        return $field_names;
    }

    // --------------------------------------------------------------------

    /**
     * Field data.
     *
     * Generates an array of objects containing field meta-data
     *
     * @return array
     */
    public function field_data()
    {
        $retval = [];
        foreach (sqlsrv_field_metadata($this->result_id) as $offset => $field) {
            $F = new stdClass();
            $F->name = $field['Name'];
            $F->type = $field['Type'];
            $F->max_length = $field['Size'];
            $F->primary_key = 0;
            $F->default = '';

            $retval[] = $F;
        }

        return $retval;
    }

    // --------------------------------------------------------------------

    /**
     * Free the result.
     *
     * @return null
     */
    public function free_result()
    {
        if (is_resource($this->result_id)) {
            sqlsrv_free_stmt($this->result_id);
            $this->result_id = false;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Data Seek.
     *
     * Moves the internal pointer to the desired offset.  We call
     * this internally before fetching results to make sure the
     * result set starts at zero
     *
     * @return array
     */
    public function _data_seek($n = 0)
    {
        // Not implemented
    }

    // --------------------------------------------------------------------

    /**
     * Result - associative array.
     *
     * Returns the result set as an array
     *
     * @return array
     */
    public function _fetch_assoc()
    {
        return sqlsrv_fetch_array($this->result_id, SQLSRV_FETCH_ASSOC);
    }

    // --------------------------------------------------------------------

    /**
     * Result - object.
     *
     * Returns the result set as an object
     *
     * @return object
     */
    public function _fetch_object()
    {
        return sqlsrv_fetch_object($this->result_id);
    }
}

/* End of file mssql_result.php */
/* Location: ./system/database/drivers/mssql/mssql_result.php */
