import {loading, toast} from './alerts';
import {getDomain} from "./tools";

const domain = getDomain('admin');

export const dev = 'https://sena.dev.tests.mx/';
export const test = 'https://sena.pruebas.territorio.la/';
export const staging = 'https://sena.tests.mx/';
export const prod = 'https://sena.territorio.la/';
export const local = 'https://sena.pruebas.local/';

// export const api = dev;
export const api = `${domain}`;

// export const api = `https://sena.pruebas.local/exportGroups`;

//Se crea headers
const myHeaders = new Headers();

myHeaders.append("Content-Type", "application/json");
myHeaders.append("Access-Control-Request-Headers", "*");
myHeaders.append("Access-Control-Request-Method", "*");


/**
 *
 * @param url
 * @param showMessage
 * @returns {Promise<any|null>}
 */
export const get = async (url, showMessage = false) => {
  loading();
  // const urlAPI = replaceAPI ? url : `${api}/${prefix}/${url}`;
  const urlAPI = `${api}${url}`;
  try {
    const response = await fetch(urlAPI);
    loading(false);
    const data = await response.json();
    if (showMessage) {
      toast(data.message, data.success);
    }
    return data ?? null;
  } catch (e) {
    toast('Error al realizar la consulta', false);
    console.log('Error al consultar', e);
    return null;
  }
};


/**
 *
 * @param url:string
 * @param payload: JSON
 * @param method: string
 * @param replaceAPI
 * @param showMessage
 * @returns {Promise<*>}
 */
export const post = async (url, payload = {}, method = 'POST', replaceAPI = false, showMessage = false) => {
  const body = JSON.stringify(payload);
  loading();
  // const urlAPI = replaceAPI ? url : `${api}/${prefix}/${url}`;
  const urlAPI = replaceAPI ? url : `${api}/${url}`;
  const options = {
    headers: myHeaders,
    method: method ? method : 'POST',
    body
  };
  try {
    const response = await fetch(urlAPI, options);
    const data = await response.json();
    loading(false);
    if (showMessage) {
      toast(data.message, data.success);
    }
    return await data;
  } catch (e) {
    toast('Error al realizar la consulta', false);
    console.log('Error al consultar', e);
    return null;
  }
};
