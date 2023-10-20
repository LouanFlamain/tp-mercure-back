import { useSelector } from "react-redux";
import Profile from "../leftPanel/Profile";
import { selectRoom } from "../redux/roomSlice";
import { useEffect, useState } from "react";
import { selectUser } from "../redux/userSlice";

const GroupProfile = () => {
  const selector = useSelector(selectRoom);
  const selectorUser = useSelector(selectUser);
  const [groupName, setGroupName] = useState("");
  useEffect(() => {
    if (selector !== null) {
      const participants = selector.participants;
      if (participants !== null) {
        if (participants.length < 3) {
          participants.map((data) => {
            if (data !== selectorUser.username) {
              setGroupName(data);
            }
          });
        } else {
          setGroupName("Groupe");
        }
        console.log(participants.length);
      }
    }
  }, [selector]);
  return (
    <div className="bg-dark w-full h-16 p-4 flex items-center rounded-tr-2xl">
      {/*<Profile />*/}
      <p className="text-clear">{groupName}</p>
    </div>
  );
};

export default GroupProfile;
