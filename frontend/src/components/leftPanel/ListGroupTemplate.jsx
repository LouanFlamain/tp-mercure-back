import Profile from "./Profile";
import { useDispatch, useSelector } from "react-redux";
import { declareRoom, selectRoom } from "../redux/roomSlice";

const ListGroupTemplate = ({ data }) => {
  const dispatch = useDispatch();
  const selector = useSelector(selectRoom);
  const [dateFormated, other] = data.last_update.date.split(" ");

  function extractUsernames(data) {
    return data.map((item) => item.username);
  }

  const handleRedux = () => {
    const usernames = extractUsernames(data.data);
    const room_data = {
      id: data.room_id,
      participants: usernames,
    };
    dispatch(declareRoom(room_data));
  };

  /*if (data.room_id === selector.id) {
    return (
      <li onClick={handleRedux} className="cursor-pointer bg-grey">
        <div className="w-full border-1 border-grey h-16 flex items-center justify-between px-4">
          <div className="flex items-center">
            <p className="mr-3">{data.data[1].username}</p>
            <p>{data.last_message}</p>
          </div>
          <time>{dateFormated}</time>
        </div>
      </li>
    );
  } else {
    return (
      <li
        onClick={handleRedux}
        className="cursor-pointer hover:bg-clear hover:text-dark"
      >
        <div className="w-full border-1 border-grey h-16 flex items-center justify-between px-4">
          <div className="flex items-center">
            <p className="mr-3">{data.data[1].username}</p>
            <p>{data.last_message}</p>
          </div>
          <time>{dateFormated}</time>
        </div>
      </li>
    );
  }*/
  return (
    <li
      onClick={handleRedux}
      className="cursor-pointer hover:bg-clear hover:text-dark"
    >
      <div className="w-full border-1 border-grey h-16 flex items-center justify-between px-4">
        <div className="flex items-center">
          <p className="mr-3">{data.data[1].username}</p>
          <p>{data.last_message}</p>
        </div>
        <time>{dateFormated}</time>
      </div>
    </li>
  );
};

export default ListGroupTemplate;
