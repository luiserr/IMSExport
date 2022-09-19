import {Button, Grid} from "@mui/material";
import {get, post} from "../../utils/request";
import {useState} from "react";
import ConfigSearch from "../Export/ConfigSearch";
import useSearch from "../Export/searchHook";
import Layout from "../commons/Layuot";

const Export = () => {

  const [typeId, setTypeId] = useState('');
  const [sourceType, setSourceType] = useState('simple');
  const [payload, setPayload] = useState(null);

  const component = useSearch(sourceType, payload, setPayload);

  const handleSearch = async () => {
    const response = await post(`export`, {typeId, payload, sourceType}, 'post', false, true);
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
    </Layout>
  );
}

export default Export;