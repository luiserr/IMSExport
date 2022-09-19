import React, {useEffect, useState} from 'react';
import {get} from "../../utils/request";
import MyTable from "../commons/table";
import {Button, Grid} from "@mui/material";
import Layout from "../commons/Layuot";

const headers = {
  'groupId': 'Id de curso',
  'createdAt': 'Fecha de creación',
  'finishedAt': 'Fecha de finalizado'
};

const Finished = () => {

  const [exports, setExports] = useState([]);

  useEffect(() => {
    getExports();
  }, []);

  const getExports = async () => {
    const response = await get('export/finished');
    if (response.success) {
      setExports(response.data);
    }
  }

  const actions = [
    <Button
      onClick={() => console.log('joder')}
    />
  ];

  return (
    <Layout title="Exportaciones finalizadas">
      <Grid xs={12}>
        <MyTable
          data={exports}
          headers={headers}
          actions={actions}
        />
      </Grid>
    </Layout>
  );
}

export default Finished;