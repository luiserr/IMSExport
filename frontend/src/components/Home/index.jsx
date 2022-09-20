import React from 'react';
import {Card, CardContent, Container} from "@mui/material";
import {Outlet} from 'react-router-dom';
import Header from "./Header";

const Body = () => {
  return (
    <>
      <Header/>
      <Container sx={{marginTop: '2em'}}>
        <Card elevation={3}>
          <CardContent>
            <Outlet/>
          </CardContent>
        </Card>
      </Container>
    </>
  );
}

Body.propTypes = {};

export default Body;
