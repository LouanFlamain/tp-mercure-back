import { useSelector } from "react-redux";
import Channel from "./Channel";
import GroupProfile from "./GroupProfile";
import GroupSearchBar from "./GroupSearchBar";
import { selectRoom } from "../redux/roomSlice";
import { useEffect, useState } from "react";

const MessagePanel = () => {
  const selector = useSelector(selectRoom);
  const token = localStorage.getItem("token");
  const [arrayMessage, setArrayMessage] = useState([]);

  //groupe name

  useEffect(() => {
    if (selector !== null) {
      getMessage(selector.id);
    }
  }, [selector]);

  const getMessage = (id) => {
    const room_id = {
      chat_id: id,
      offset: 0,
    };

    fetch("http://localhost:9000/api/get_message", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`,
      },
      credentials: "include",
      body: JSON.stringify(room_id),
    })
      .then((response) => response.json())
      .then((results) => {
        setArrayMessage(results.data.reverse());
      });
  };
  return (
    <div className="bg-darker h-full w-full border-grey border-2 flex flex-col justify-between rounded-r-2xl">
      <GroupProfile />
      <Channel message={arrayMessage} setMessage={setArrayMessage} />
      <GroupSearchBar selector={selector} />
    </div>
  );
};
export default MessagePanel;
