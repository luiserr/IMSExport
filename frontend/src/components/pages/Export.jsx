import {Button, Grid} from "@mui/material";
import {get, post} from "../../utils/request";
import {useEffect, useState} from "react";
import ConfigSearch from "../Export/ConfigSearch";
import useSearch from "../Export/searchHook";
import Layout from "../commons/Layuot";
import Exports from "../Export/Exports";

const Export = () => {

  const [typeId, setTypeId] = useState('');
  const [sourceType, setSourceType] = useState('simple');
  const [payload, setPayload] = useState(null);
  const [exports, setExports] = useState([]);

  useEffect(() => {
    getExports();
  }, []);

  const getExports = async () => {
    const response = await get('exportGroups/export');
    if (response.success) {
      setExports(response.data);
    }
  };


  const component = useSearch(sourceType, payload, setPayload);

  const handleSearch = async () => {
    const response = await post(`export`, {typeId, payload, sourceType}, 'post', false, true);
    await getExports();
  };

  return (
    <Layout title="Crear exportaciones">
      <ConfigSearch
        typeId={typeId}
        setTypeId={setTypeId}
        sourceType={sourceType}
        setSourceType={setSourceType}
      />
      {
        component
      }
      <Grid item xs={3}>
        <Button variant="outlined" onClick={handleSearch}>Crear</Button>
      </Grid>
      <Grid item xs={12}>
        <Exports exports={exports} searchExports={setExports}/>
      </Grid>
    </Layout>
  );
}

export default Export;