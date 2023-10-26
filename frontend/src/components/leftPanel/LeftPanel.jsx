import { BiLogOut } from "react-icons/bi";
import { useDispatch, useSelector } from "react-redux";
import { addUser, selectUser } from "../redux/userSlice";
import { useAsyncError, useNavigate } from "react-router-dom";
import Profile from "./Profile";
import UserBar from "./userBar";
import SearchBar from "./SearchBar";
import { useEffect, useRef, useState } from "react";
import ListGroups from "./ListGroups";
import SearchUserCard from "./SearchUserCard";
import MercureSubscription from "../mercureSubsciption";

const LeftPanel = () => {
  // value pour trier les groupes
  const [searchFields, setSearchFields] = useState("");
  // bool si le pop up est ouvert
  const [addUserDisplay, setAddUserDisplay] = useState(false);
  // value barre de add user
  const [userSearchValue, setUserSearchValue] = useState("");
  // tableau fetch
  const [dataArray, setDataArray] = useState([]);

  const userData = useSelector(selectUser);

  let ref = useRef(false);

  //liste de chat

  const [listChat, setListChat] = useState([]);

  const token = localStorage.getItem("token");
  const id = {
    id: userData.id,
  };

const handleNewMessage = () =>{
  console.log("nouveau message")
}

  useEffect(() => {
    if (!ref.current) {
      fetch("http://localhost:9000/api/get_chat", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Autorization: `Bearer ${token}`,
        },
        credentials: "include",
        body: JSON.stringify(id),
      })
        .then((response) => response.json())
        .then((results) => {
          setListChat(results.data);
          console.log(results.data);
        });

      ref.current = true;
    }
  }, []);

  useEffect(() => {
    if (userSearchValue === "") {
      setDataArray([]);
      return;
    }

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
      <UserBar
        addUser={setAddUserDisplay}
        state={addUserDisplay}
        userData={userData}
      />
      <SearchBar setSearchFields={setSearchFields} />
      <ListGroups listChat={listChat} />
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
      <MercureSubscription topic="http://localhost:9090/chat/1" onMessage={handleNewMessage} />
    </div>
  );
};
export default LeftPanel;
