async function clubDoesNotExist(webcode:string){

    const response = await fetch("https://admin.hgverwaltung.ch/api/1/"+webcode+"/mannschaften");
    const data = await response.json();
    console.log(data.length==0);
    debugger
    return data.length==0;
}
export default clubDoesNotExist;