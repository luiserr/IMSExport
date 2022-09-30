import React from 'react';
import {Route, Routes} from 'react-router-dom';
import Body from "../components/Home";
import Export from "../components/pages/Export";
import InProgress from "../components/pages/InProgress";
import Finished from "../components/pages/finished";

const MyRoutes = () => {
  return (
    <>
      <Routes>
        <Route name="home" path="/admin/exports/" exact element={<Body/>}>
          <Route name="export" path="/admin/exports/" exact element={<Export/>}/>
          <Route name="inProgress" path="/admin/exports/inProgress" exact element={<InProgress/>}/>
          <Route name="finished" path="/admin/exports/finished" exact element={<Finished/>}/>
        </Route>
      </Routes>
    </>
  );
}

export default MyRoutes;