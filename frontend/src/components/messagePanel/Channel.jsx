import { useSelector } from "react-redux";
import EndChat from "./chatBubble/EndChat";
import StartChat from "./chatBubble/StartChat";
import { selectUser } from "../redux/userSlice";

const Channel = ({ message, setMessage }) => {
  const userSelector = useSelector(selectUser);
  const username = userSelector.username;

  return (
    <div className="w-ful h-message flex flex-col justify-end px-2 background-img">
      <div className="overflow-scroll">
        {message.map((data, index) => {
          if (data.username === username) {
            return <EndChat data={data} key={index} />;
          } else {
            return <StartChat data={data} key={index} />;
          }
        })}
      </div>
    </div>
  );
};

export default Channel;
