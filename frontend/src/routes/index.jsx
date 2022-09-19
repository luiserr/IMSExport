import React from 'react';
import {Route, Routes} from 'react-router-dom';
import Body from "../components/Home";
import Export from "../components/pages/Export";
import InProgress from "../components/pages/InProgress";
import Finished from "../components/pages/finished";

const MyRoutes = () => {
  return (
    <Routes>
      <Route path="/" element={<Body/>}>
        <Route path="/" element={<Export/>}/>
        <Route path="/inProgress" element={<InProgress/>}/>
        <Route path="/finished" element={<Finished/>}/>
      </Route>
    </Routes>
  );
}

export default MyRoutes;