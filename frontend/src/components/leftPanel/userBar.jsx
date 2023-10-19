import Profile from "./Profile";
import { BiLogOut, BiSolidMessageAdd } from "react-icons/bi";
import { useDispatch } from "react-redux";
import { addUser } from "../redux/userSlice";
import { useNavigate } from "react-router-dom";

const UserBar = ({ state, addUser, userData }) => {
  const dispatch = useDispatch();
  const navigate = useNavigate();

  const handleClick = () => {
    if (!state) {
      addUser(true);
    } else {
      addUser(false);
    }
  };

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
        <Profile userImage={userData.image} />
        <p
          className="text-clear"
          onClick={() => console.log(userData.username)}
        >
          {userData.username}
        </p>
      </div>
      <div className="flex">
        <div
          className="cursor-pointer mr-6"
          style={{
            transform: "scale(2)",
          }}
        >
          <BiSolidMessageAdd
            onClick={handleClick}
            style={{ color: "#F0F8FF" }}
          />
        </div>
        <div
          onClick={Disconnect}
          className="cursor-pointer"
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
