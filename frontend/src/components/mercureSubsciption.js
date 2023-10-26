import { useEffect } from "react";
import axios from "axios";


const MercureSubscription = ({ topic, onMessage }) => {
    const jwtKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWJzY3JpYmUiOlsiaHR0cDovL2xvY2FsaG9zdDo5MDkwL21lc3NhZ2UvMSJdfQ.4co4aFg8HVaGbr6ClHrh-i3lbDaJOLjtiCxF75rdwVI";
    const channel = `http://localhost:9090/.well-known/mercure?topic=${topic}&authorization=${jwtKey}`;

     const  headers = {
        Authorization: `Bearer ${jwtKey}`,
        "Content-Type": "text/event-stream",
      }

      const eventSource = new EventSource(channel,  { withCredentials: true });
  
      eventSource.onmessage = (event) => {
        const data = JSON.parse(event.data);
        console.log(data);
      };
  
      eventSource.onerror = (error) => {
        console.error(error);
      };

  };
  export default MercureSubscription;
  
