import React, {useEffect, useState} from 'react';
import {api, get} from "../../utils/request";
import MyTable from "../commons/table";
import {Button, Grid} from "@mui/material";
import Layout from "../commons/Layuot";
import DownloadIcon from '@mui/icons-material/Download';

const headers = {
  'id': 'Id',
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

  const downLoad = (id) => {
    window.open(`${api}/download/${id}`);
  };

  const actions = [{
    title: 'Descargar',
    component: ({id}) => <Button
      onClick={() => downLoad(id)}
      startIcon={<DownloadIcon/>}
    />
  }
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