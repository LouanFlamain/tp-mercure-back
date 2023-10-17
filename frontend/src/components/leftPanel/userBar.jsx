import Profile from "./Profile";
import { BiLogOut } from "react-icons/bi";
import { useDispatch } from "react-redux";
import { addUser } from "../redux/userSlice";
import { useNavigate } from "react-router-dom";

const UserBar = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();

  const Disconnect = () => {
    localStorage.clear("token");
    dispatch(addUser(null));
    navigate("/login");
  };
  return (
    <div
      id="my_account"
      className="bg-dark flex p-4 justify-between items-center h-16 rounded-tl-2xl"
    >
      <div className="flex items-center">
        <Profile />
        <p className="text-clear">username</p>
      </div>
      <div>
        <div
          onClick={Disconnect}
          className="cursor-pointer ho"
          style={{
            transform: "scale(2)",
          }}
        >
          <BiLogOut style={{ color: "#F0F8FF" }} />
        </div>
      </div>
    </div>
  );
};
export default UserBar;
