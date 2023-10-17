import { BiLogOut } from "react-icons/bi";
import { useDispatch } from "react-redux";
import { addUser } from "../redux/userSlice";
import { useNavigate } from "react-router-dom";
import Profile from "./Profile";
import UserBar from "./userBar";
import SearchBar from "./SearchBar";
import { useState } from "react";
import ListGroups from "./ListGroups";

const LeftPanel = () => {
  const [searchFields, setSearchFields] = useState("");
  return (
    <div className="h-full w-112 bg-dark border-grey border-2 rounded-l-2xl">
      <UserBar />
      <SearchBar setSearchFields={setSearchFields} />
      <ListGroups />
    </div>
  );
};
export default LeftPanel;
