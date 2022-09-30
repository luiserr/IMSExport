import React, {useEffect, useState} from 'react';
import {get} from "../../utils/request";
import MyTable from "../commons/table";
import {Container, Grid, Typography} from "@mui/material";
import Layout from "../commons/Layuot";

const headers = {
  'groupId': 'Id de curso',
  'createdAt': 'Fecha de creación',
  'startedAt': 'Fecha de inicio'
};

const InProgress = () => {

  const [exports, setExports] = useState([]);

  useEffect(() => {
    getExports();
  }, []);

  const getExports = async () => {
    const response = await get('exportGroups/export/inProgress');
    if (response.success) {
      setExports(response.data);
    }
  }

  return (
    <Layout title="Exportaciones de cursos">
      <Grid xs={12}>
        <MyTable
          data={exports}
          headers={headers}
        />
      </Grid>
    </Layout>
  );
}

export default InProgress;