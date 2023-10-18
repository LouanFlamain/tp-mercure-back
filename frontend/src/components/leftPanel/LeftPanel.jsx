import { BiLogOut } from "react-icons/bi";
import { useDispatch } from "react-redux";
import { addUser } from "../redux/userSlice";
import { useAsyncError, useNavigate } from "react-router-dom";
import Profile from "./Profile";
import UserBar from "./userBar";
import SearchBar from "./SearchBar";
import { useEffect, useState } from "react";
import ListGroups from "./ListGroups";
import SearchUserCard from "./SearchUserCard";

const LeftPanel = () => {
  // value pour trier les groupes
  const [searchFields, setSearchFields] = useState("");
  // bool si le pop up est ouvert
  const [addUserDisplay, setAddUserDisplay] = useState(false);
  // value barre de add user
  const [userSearchValue, setUserSearchValue] = useState("");
  // tableau fetch
  const [dataArray, setDataArray] = useState([]);

  useEffect(() => {
    if (userSearchValue === "") {
      setDataArray([]);
      return;
    }
    const token = localStorage.getItem("token");

    const req = {
      search: userSearchValue,
    };
    fetch("http://localhost:9000/api/search_user", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Autorization: `Bearer ${token}`,
      },
      credentials: "include",
      body: JSON.stringify(req),
    })
      .then((response) => response.json())
      .then((result) => {
        setDataArray(result.users);
      });
  }, [userSearchValue]);

  return (
    <div className="h-full w-112 bg-dark border-grey border-2 rounded-l-2xl">
      <UserBar addUser={setAddUserDisplay} state={addUserDisplay} />
      <SearchBar setSearchFields={setSearchFields} />
      <ListGroups />
      {addUserDisplay ? (
        <div className="is-absolute-center z-50">
          <SearchUserCard
            props={setUserSearchValue}
            data={dataArray}
            addUser={setAddUserDisplay}
          />
        </div>
      ) : (
        <div></div>
      )}
    </div>
  );
};
export default LeftPanel;
