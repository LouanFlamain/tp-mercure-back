import { useEffect, useRef } from "react";
import { useLocation, useNavigate } from "react-router-dom";
import { useSelector, useDispatch } from "react-redux";
import { selectUser, addUser } from "../redux/userSlice";
import { KJUR } from "jsrsasign";

const NeedAuth = ({ children }) => {
  let ref = useRef(false);

  const user = useSelector(selectUser);
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const location = useLocation();

  const token = localStorage.getItem("token");

  useEffect(() => {
    if (!ref.current) {
      if (token !== null) {
        const publicKey = atob(process.env.REACT_APP_JWT_PUBLIC_KEY);

        const isValid = KJUR.jws.JWS.verifyJWT(token, publicKey, {
          alg: ["RS256"],
        });

        if (isValid) {
          if (user === null) {
            // À implémenter : logique route /api/get_informations
            let [header, payload, signature] = token.split(".");
            payload = JSON.parse(atob(payload));

            const data = {
              email: payload.email,
            };
            //console.log(payload.email);
            fetch("http://localhost:9000/api/get_informations", {
              headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${token}`,
              },
              credentials: "include",
              method: "POST",
              body: JSON.stringify(data),
            })
              .then((response) => response.json())
              .then((data) => {
                if (data.code === 200) {
                  const user = {
                    email: data.email,
                    username: data.username,
                    role: data.role,
                    id: data.id,
                    creation_date: data.createdAt.date,
                  };
                  dispatch(addUser(user));
                } else {
                  navigate("/login", { state: location });
                }
              });
          }
        } else {
          localStorage.clear("token");
          navigate("/login", { state: location });
        }
      } else {
        navigate("/login", { state: location });
      }
    }
    ref.current = true;
  }, []);

  return children;
};

export default NeedAuth;
