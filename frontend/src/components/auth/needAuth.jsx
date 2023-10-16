import { useEffect, useRef } from "react";
import { useLocation, useNavigate } from "react-router-dom";
import { useSelector } from "react-redux";
import { selectUser } from "../redux/userSlice";

const NeedAuth = ({ children }) => {
  let ref = useRef(false);
  const user = useSelector(selectUser);
  const navigate = useNavigate();
  const location = useLocation();
  const token = localStorage.getItem("token");
  const params = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${token}`,
    },
    credentials: "include",
  };
  useEffect(() => {
    if (!ref.current) {
      console.log("test");
      if (token !== null) {
        if (user !== null) {
          fetch("http://localhost:9000/api/check_valid", params)
            .then((respones) => respones.json())
            .then((data) => {
              //data.code = 200;
              if (data.code === 200) {
                return <div>{children}</div>;
              }
              navigate("/login", { state: location });
            });
        } else {
          var [header, payload, signature] = token.split(".");
          let decode = atob(payload);
          decode = JSON.parse(decode);
          console.log(decode.email);
          //implémenter logique route /api/get_informations
        }
      } else {
        navigate("/login", { state: location });
      }
    }
    ref.current = true;
  }, []);
};
export default NeedAuth;
