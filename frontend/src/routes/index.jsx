import React from 'react';
import {Route, Routes} from 'react-router-dom';
import Body from "../components/Home";
import Export from "../components/pages/Export";

const MyRoutes = () => {
  return (
    <Routes>
      <Route path="/" element={<Body/>}>
        <Route path="export" element={<Export/>}/>
      </Route>
    </Routes>
  );
}

export default MyRoutes;