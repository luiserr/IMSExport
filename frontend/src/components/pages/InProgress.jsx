import React, {useEffect, useState} from 'react';
import {get} from "../../utils/request";
import MyTable from "../commons/table";

const headers = {
  'groupId': 'Id de curso',
  'createdAt': 'Fecha de creación'
};

const InProgress = () => {

  const [exports, setExports] = useState([]);

  useEffect(() => {
    getExports();
  }, []);

  const getExports = async () => {
    const response = await get('export');
    if (response.success) {
      setExports(response.data);
    }
  }

  return (
    <div>
      <MyTable
        data={exports}
        headers={headers}
        />
    </div>
  );
}

export default InProgress;